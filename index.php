<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
      .topsec{
        background-color:blanchedalmond;
        padding: 20px 20px;
      margin: 20px;
        display: flex;
      border-radius: 40px;
      }
      #heroimg{
        width:65%;
        height:auto;
        border-radius: 10px;
        margin: 10px;
      }
      .topsec p{
        font-size: 30px;
        margin-left:30px;
        margin-top:10%;
      }
      .loan{
        background-color: lightsalmon;
        width:93%;
        margin:0 20px ;
        padding: 20px;
        border-radius: 40px;
      }
      .loan h2{
        text-align: center;
        margin-bottom: 0;
      }
      .loan p{
        font-size: larger;
        text-align: center;
        margin-top: 0;
      }
      #predict{
        padding: 15px;
        background-color: gold;
        font-size: large;
        font-weight: bold;
        color:black;
        border-radius: 10px;
        margin-left: 44%;
        cursor: pointer;
        transition: background-color 0.3s;
      }
      #predict:hover{
        background-color: orange;
        color:white;
      }
    </style>
  </head>
<body>
    <header>
          <div>
            <img src="./assets/logo.jpg" alt="HomeCoMS Logo" class="logo">
            <span id="title">HomeCoMS</span>
          </div>
        <nav>
            <ul>
                <li><a href="./registration.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="topsec">
        <img id="heroimg" src="./assets/homeimg.jpeg" alt="Hero Image">
        <p>Welcome to HomeCoMS, your one-stop solution for managing house construction activities. With our intuitive platform, you can streamline your construction projects, manage tasks, budgets, timelines, and more.</p>
    </section>
    <section class="features">      
        <h2 class="featureis">Features</h2>
        <div class="feature1">
          <div class="feature">
            <img src="./assets/taskmgmt.png" class="featurephoto" alt="feature 1">
            <h4>Task Management</h4>
            <p>This allows you to delegate tasks, monitor progress, and manage deadlines effectively.</p>
          </div>
          <div class="feature">
            <img src="./assets/commcol.png" class="featurephoto" alt="feature 2">
            <h4>Communication 
                and Collaboration</h4>
            <p>Efficient communication and collaboration among stakeholders is facilitated.
            </p>
          </div>
          <div class="feature">
            <img src="./assets/schedule.png" class="featurephoto" alt="feature 3">
            <h4>Scheduling
            </h4>
            <p>The tool aids in planning and scheduling tasks and milestones.
            </p>
          </div>
          <div class="feature">
            <img src="./assets/budget.png" class="featurephoto" alt="feature 4">
            <h4>Budgeting and Cost Controls
            </h4>
            <p>The software  assists in tracking expenses and controlling costs.</p>         
          </div>
          <div class="feature">
            <img src="./assets/resourcemgmt.png" class="featurephoto" alt="feature 5">
            <h4>Resources Management
            </h4>
            <p>A series of processes and techniques to ensure all the necessary resources are available on time with quality.
            </p>
          </div>
          <div class="feature">
            <img src="./assets/lap.png" class="featurephoto" alt="feature 6">
            <h4>Loan Approval Prediction
            </h4>
            <p>Loan approval prediction for homeowners to aid financial planning.
            </p>
          </div>
          </div>
      </section> 
    <section class="loan">
        <h2>Loan Prediction</h2><br>
        <p>Want to build a home and worried about getting a loan. Don't worry check out if you are eligible to take a laon.</p>
        <a href="http://127.0.0.1:5000/"><button id="predict">Let's Predict</button></a>
    </section>
    <section class="testimonials">
        <h2>"Testimonials"</h2>
        <div class="testimonial1">
            <div class="testimonial">
              <h4>Sunita Deshmukh</h4>
              <p>"HomeCoMS revolutionized the way I manage my construction projects. With its user-friendly interface and powerful features, I can now oversee every aspect of my projects effortlessly. Highly recommended!"</p>
            </div>
            <div class="testimonial">
              <h4>Vikram Singhania</h4>
              <p>"I've tried many construction management tools before, but HomeCoMS stands out for its simplicity and effectiveness. It's like having a personal assistant for my projects. Thank you, HomeCoMS team!"</p>
            </div>
            <div class="testimonial">
              <h4>Rahul Sharma</h4>
              <p>"Managing multiple construction sites was always a challenge until I discovered HomeCoMS. Now, I can monitor progress, track expenses, and communicate with my team effortlessly. It's a game-changer!"</p>
            </div>
            <div class="testimonial">
              <h4>Arun Khanna</h4>
              <p>"I was skeptical about using construction management software, but HomeCoMS exceeded my expectations. Its intuitive interface and comprehensive features have made managing my projects a breeze. Thank you for this amazing tool!"</p>         
            </div>
            <div class="testimonial">
              <h4>Norman Foster</h4>
              <p>"As an architect, staying organized is crucial for me. HomeCoMS has been a lifesaver! From budget tracking to task management, it has everything I need to keep my projects on track. Great job!"</p>
            </div>
            <div class="testimonial">
              <h4>Krishna Gupta </h4>
              <p>"HomeCoMS has simplified my life as a homeowner. It has everything I need to ensure my projects run smoothly. I couldn't be happier!"</p>
            </div>
            </div>
    </section>
    <footer>
        <p>&copy; 2024 HomeCoMS. All rights reserved.</p>
    </footer>
</body>
</html>
