# Recipe Recommender System

This project is a **Recipe Recommender System** built using a Flask backend for machine learning model serving and a Laravel frontend for user interaction. The application generates recipe suggestions based on user preferences such as spice level and price range. 

## Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Usage](#usage)
- [Model](#model)
- [Dataset](#dataset)
- [API Endpoints](#api-endpoints)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## Project Overview

The system recommends recipes tailored to user preferences. Users can select their preferred **spice level** (e.g., mild or spicy) and **price range** (e.g., affordable, moderate-expensive) and get a suggested recipe along with the main ingredients and a short description.

The machine learning model is trained on a custom dataset and predicts recipes based on **spice level** and **price range**. The Flask app serves as the backend API that generates the recipes, while the Laravel app is used for user interactions and frontend display.

## Features

- User can select their preferred spice level and price range.
- The backend uses a machine learning model to generate recipes based on the input.
- Recipes include the name, ingredients, and a description.
- Seamless interaction between Laravel and Flask applications.
- Flask API for generating and returning recipes based on user input.

## Tech Stack

- **Frontend**: Laravel
- **Backend**: Flask
- **Machine Learning**: Scikit-learn (Random Forest Classifier)
- **Database**: SQLite (or another database for user preferences)
- **Languages**: PHP, Python, JavaScript

## Project Structure

```bash
recipe-recommender/
├── recipe-recommender-app/   # Laravel frontend app
├── recipe_generator_app/     # Flask backend app for recipe generation
├── recipe_dataset.csv        # Dataset used for training the ML model
├── food_classification_model.pkl # Trained machine learning model
├── model_generator.py        # Script to train the model
└── README.md                 # Project documentation
```

### Laravel App Structure

The Laravel application is structured as follows:

```bash
recipe-recommender-app/
├── app/
├── config/
├── resources/
├── routes/
└── ...
```

### Flask App Structure

The Flask application is structured as follows:

```bash
recipe_generator_app/
├── app.py                    # Flask server logic
├── food_classification_model.pkl # Trained machine learning model
└── requirements.txt          # Dependencies for Flask app
```

## Installation

### Prerequisites

Ensure you have the following installed:
- Python 3.8+
- PHP 7.4+
- Composer
- Node.js & NPM
- Scikit-learn, Flask, Pandas (for the Flask backend)

### Step-by-Step Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/recipe-recommender.git
   cd recipe-recommender
   ```

2. **Set up the Flask backend**:
   - Navigate to the `recipe_generator_app` directory:
     ```bash
     cd recipe_generator_app
     ```
   - Install dependencies:
     ```bash
     pip install -r requirements.txt
     ```
   - Run the Flask server:
     ```bash
     python app.py
     ```

3. **Set up the Laravel frontend**:
   - Navigate to the Laravel app:
     ```bash
     cd recipe-recommender-app
     ```
   - Install Composer dependencies:
     ```bash
     composer install
     ```
   - Install NPM dependencies:
     ```bash
     npm install
     ```
   - Set up the environment variables by copying `.env.example` to `.env` and update the database and other configuration:
     ```bash
     cp .env.example .env
     php artisan key:generate
     ```
   - Migrate the database:
     ```bash
     php artisan migrate
     ```
   - Serve the Laravel application:
     ```bash
     php artisan serve
     ```

4. **Train the model (if necessary)**:
   - Run the `model_generator.py` script in the root directory to generate a new model:
     ```bash
     python model_generator.py
     ```

## Usage

1. Start both the Flask backend and the Laravel frontend.
   - Flask should be running on `http://localhost:5000`.
   - Laravel should be running on `http://localhost:8000`.

2. Visit the Laravel dashboard, where you can choose your recipe preferences (spice level and price range) and click **Generate Recipe**.

3. The system will communicate with the Flask API to return a recommended recipe, which is displayed on the dashboard.

## Model

- The ML model is built using a Random Forest Classifier from the **Scikit-learn** library.
- Features used for prediction:
  - `Spice_Level`
  - `Price_Range`
- The target for prediction includes:
  - `Food_Name`
  - `Main_Ingredients`
  - `Description`

## Dataset

The dataset used in this project was sourced from **Kaggle**, and it has been fine-tuned to suit the project’s specific needs. The original dataset is available at [Kaggle - Nigerian Foods Dataset](https://www.kaggle.com/datasets/franklycypher/nigerian-foods). 

Adjustments were made to include user preference features like **spice level** and **price range** to enhance the recommendation model.

## API Endpoints

### Flask API

| Endpoint          | Method | Description                                 |
|-------------------|--------|---------------------------------------------|
| `/generate-recipe` | POST   | Generate a recipe based on spice level and price range |

**Sample POST Request**:
```bash
POST http://localhost:5000/generate-recipe
Content-Type: application/json

{
  "spice_level": "Mild",
  "price_range": "Affordable"
}
```

## Troubleshooting

- **Model always generating the same result**: Ensure the model is correctly retrained with sufficient data.
- **Laravel not connecting to Flask**: Check CORS settings and ensure both apps are running on the correct ports.
- **Flask 500 error**: Use `app.run(debug=True)` in the Flask app to trace the error logs.

## Contributing

Feel free to open issues or submit pull requests if you'd like to contribute!

## License

This project is licensed under the MIT License.

---