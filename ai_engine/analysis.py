import pandas as pd
import os

file_path = '/var/www/storage/app/orders_data.csv'

if os.path.exists(file_path):
    #Chargement du csv
    sales_data = pd.read_csv(file_path)

    #Pretraitement : convertir la colone "date" en date
    sales_data['date'] = pd.to_datetime(sales_data['date'])

    print("--- ANALYSE DE SAISONALITE---")

    #Identifier les pics, ventes par mois
    #cree une colone month
    sales_data['month'] = sales_data['date'].dt.to_period('M')
    monthly_sales = sales_data.groupby('month')['quantity'].sum()

    print("Ventes mensuelles globales :")
    print(monthly_sales)

    #Prediction simple
    #tendence des 3 derniers mois pour predire le mois prochain
    last_3_months_avg = monthly_sales.tail(3).mean()

    print(f"\nPrédiction de demande pour le mois prochain : {round(last_3_months_avg, 2)} unités")

else:
    print("Fichier CSV introuvable. Lancer 'docker compose exec app php  artisan app:export-orders-to-c-s-v'")

