# asp.net test
ASP.NET test yayasan peneraju


1) Setting Up the Database

Create a database and table to store survey response

Database :

CREATE DATABASE feedback_survey;

USE feedback_survey;

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    document VARCHAR(255),
    feedback_type ENUM('Positive', 'Negative') NOT NULL,
    services SET('Service1', 'Service2', 'Service3'),
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

2) ASP.NET MVC Application Setup

3)
Step 1: Create a New ASP.NET MVC Project
-Open Visual Studio and create new ASP.NET Core Web Application.
-CHoose the MVC template

Step 2 Install Necessary Pakages

For MYSQL: 

dotnet add package MySql.Data
dotnet add package Pomelo.EntityFrameworkCore.MySql

Step 3 : Define the Model
Models/Feedback.cs

Step 4 : Set up the Database Context
Data/ApplicationDbCOntext.cs

Step5: COnfigure the database in 'Startup.cs'
For MySQL :

public void ConfigureServices(IServiceCollection services)
{
    services.AddDbContext<ApplicationDbContext>(options =>
        options.UseMySql(Configuration.GetConnectionString("DefaultConnection"),
            new MySqlServerVersion(new Version(8, 0, 21))));
    services.AddControllersWithViews();
}

appsettings.json

For MySQL:

{
  "ConnectionStrings": {
    "DefaultConnection": "Server=localhost;Database=feedback_survey;User=root;Password=yourpassword;"
  }
}

Step 6 : Create the COntroller
Controleer/FeedbackController.cs

Step 7 : Create the views
Views/Feedback/INdex.cshtml
Views/Feedback/Create.cshtml


