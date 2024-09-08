from flask import Flask, request, jsonify
import pandas as pd
import joblib
import json

app = Flask(__name__)

# Load the model
model = joblib.load('../food_classification_model.pkl')

@app.route('/generate-recipe', methods=['POST'])
def generate_recipe():
    try:
        # Get the input data from the request
        input_data = request.get_json()

        # Extract spice level and price range from the input data
        spice_level = input_data.get('spice_level')
        price_range = input_data.get('price_range')

        # Create a DataFrame with the required input columns
        df = pd.DataFrame({
            'Spice_Level': [spice_level],
            'Price_Range': [price_range]
        })

        # Make prediction
        prediction = model.predict(df)

        # Extract predictions assuming it's an array of arrays
        food_name = prediction[0][0]  # Adjust based on the output format
        main_ingredients = prediction[0][1]  # Adjust based on the output format
        description = prediction[0][2]  # Adjust based on the output format

        # Construct the recipe
        recipe = {
            'food_name': food_name,
            'main_ingredients': main_ingredients,
            'description': description,
            'spice_level': spice_level,
            'price_range': price_range
        }

        # Print recipe to terminal
        print("Generated Recipe:", json.dumps(recipe, indent=4))

        # Append recipe to a text file
        with open('generated_recipes.txt', 'a') as file:
            file.write(json.dumps(recipe, indent=4) + '\n')

        return jsonify(recipe)
    
    except Exception as e:
        # Print error details for debugging
        print(f"Error: {e}")
        return jsonify({'error': str(e)}), 500

if __name__ == "__main__":
    app.run(debug=True)
