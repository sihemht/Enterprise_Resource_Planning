import pandas as pd
import os
import numpy as np
from sklearn.linear_model import LinearRegression

file_path = '/var/www/storage/app/orders_data.csv'

if os.path.exists(file_path):
    #Prepare les données
    df = pd.read_csv(file_path)
    df['date'] = pd.to_datetime(df['date'])

    #regroupe par mois pour avoir une tendance
    monthly = df.groupby(df['date'].dt.to_period('M'))['quantity'].sum().reset_index()

    #transforme les mois en nombre
    monthly['month_index'] = np.arange(len(monthly)).reshape(-1, 1)
    X = monthly[['month_index']] #temps
    Y = monthly['quantity']     #ventes

    #entrainement
    model = LinearRegression() # y = ax + b
    model.fit(X,Y)

    #prediction pour le mois suivant
    next_month_index = np.array([[len(monthly)]])
    prediction = model.predict(next_month_index)

    print("---RESULTAT DU MODEL IA ---")
    print(f"Coefficient de croissance : {round(model.coef_[0], 2)}")
    print(f"Prédiction pour le mois prochain : {round(prediction[0], 2)} unités")
else:
    print("Fichier CSV introuvable. Lancer 'docker compose exec app php  artisan app:export-orders-to-c-s-v'")
