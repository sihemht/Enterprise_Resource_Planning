import os
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt


file_path = '/var/www/storage/app/orders_data.csv'

if os.path.exists(file_path):
    df = pd.read_csv(file_path)
    df['date'] = pd.to_datetime(df['date'])
    monthly = df.groupby(df['date'].dt.to_period('M'))['quantity'].sum().reset_index()
    monthly['month_index'] = np.arange(len(monthly)).reshape(-1, 1)

    X = monthly[['month_index']]
    y = monthly['quantity']
    model = LinearRegression().fit(X, y)

    #generation du graph
    plt.figure(figsize=(10, 6))

    # Points bleus : Ventes réelles
    plt.scatter(X, y, color='blue', label='Ventes réelles (Passé)')

    # Ligne rouge : La tendance calculée
    plt.plot(X, model.predict(X), color='red', linewidth=2, label='Tendance IA (Prédiction)')

    # Personnalisation
    plt.title('Analyse Prédictive des Ventes ERP', fontsize=14)
    plt.xlabel('Mois (Index)', fontsize=12)
    plt.ylabel('Unités vendues', fontsize=12)
    plt.legend()
    plt.grid(True, linestyle='--', alpha=0.6)

    # 3. SAUVEGARDE
    output_path = '/var/www/storage/app/prediction_chart.png'
    plt.savefig(output_path)
    print(f"--- SUCCÈS ---")
    print(f"Le graphique a été généré ici : {output_path}")

else:
    print("Fichier CSV introuvable. Lancer 'docker compose exec app php  artisan app:export-orders-to-c-s-v'")
