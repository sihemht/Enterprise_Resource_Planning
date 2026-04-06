import requests
import pandas as pd

API_URL = "http://localhost:8000/api/dashboard/stats"

print(f"Connexion a l'API : {API_URL}")

try:
    response = requests.get(API_URL)
    response.raise_for_status() #verifie si requete code 200

    data = response.json()

    prediction_df = pd.DataFrame(data['ai_stock_predictions'])

    print("\n--- RÉCUPÉRATION TEMPS RÉEL RÉUSSIE ---")
    print(f"Chiffre d'affaires total: {data['total_revenue']}$, commande : {data['orders_count']}")
    print("\nFocus sur les alertes de stock :")
    print(prediction_df[['product_name','status', 'days_remaining']])

except Exception as e:
    print(f"Erreur lors de la récuppération : {e}")
