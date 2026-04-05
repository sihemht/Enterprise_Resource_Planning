import pandas as pd

#Charger les données DataFrame
sales_data = pd.read_csv('storage/app/orders_data.csv')

print("---- ANALYSE DE L'HISTORIQUE DES VENTES ----")

sales_by_product = sales_data.groupby('product')['quantity'].sum().sort_values(ascending=False)

print("Quantités totales vendues par article :")
print(sales_by_product)

# 3. Analyser la performance par catégorie
# Pour savoir si les 'VTT' se vendent mieux que les 'Accessoires'
sales_by_category = sales_data.groupby('category')['amount'].sum()

print("\nChiffre d'affaires par catégorie :")
print(sales_by_category)

print("\nChiffre d'affaires en France :")
french_sales = sales_data[sales_data['customer_country'] == 'France']
print(french_sales)
