# app.py

from flask import Flask, request, jsonify, render_template
import pandas as pd
import pickle

app = Flask(__name__)

# Load the model and preprocessor
with open('loan_model.pkl', 'rb') as model_file:
    model = pickle.load(model_file)

with open('preprocessor.pkl', 'rb') as preprocessor_file:
    preprocessor = pickle.load(preprocessor_file)

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/predict', methods=['POST'])
def predict():
    user_input = {
        "Gender": request.form['Gender'],
        "Married": request.form['Married'],
        "Dependents": request.form['Dependents'],
        "Education": request.form['Education'],
        "Self_Employed": request.form['Self_Employed'],
        "ApplicantIncome": float(request.form['ApplicantIncome']),
        "CoapplicantIncome": float(request.form['CoapplicantIncome']),
        "LoanAmount": float(request.form['LoanAmount']),
        "Loan_Amount_Term": float(request.form['Loan_Amount_Term']),
        "Credit_History": float(request.form['Credit_History']),
        "Property_Area": request.form['Property_Area']
    }
    
    user_df = pd.DataFrame([user_input])
    user_df['TotalIncome'] = user_df['ApplicantIncome'] + user_df['CoapplicantIncome']

    user_input_processed = preprocessor.transform(user_df)

    prediction = model.predict(user_input_processed)

    if prediction[0] == 'Y':
        return render_template('index.html', prediction_text="Congratulations! You are eligible for a loan.")
    else:
        return render_template('index.html', prediction_text="Sorry, you are not eligible for a loan.")

if __name__ == "__main__":
    app.run(debug=True)
