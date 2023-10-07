# Sibling Scorecard System

The Sibling Scorecard System is a web application designed to help you manage and assess the performance of siblings in various aspects. This system allows you to record and track scores for individual siblings in different categories and provides a scoring sheet for easy assessment.

![Screenshot of the Sibling Scorecard System](screenshot.png)

## Table of Contents

- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
  - [Adding a Sibling](#adding-a-sibling)
  - [Updating Scores](#updating-scores)
  - [Importing Data](#importing-data)
  - [Using the Scoring Sheet](#using-the-scoring-sheet)
- [Features](#features)
- [Database Schema](#database-schema)
- [Scoring Sheet](#scoring-sheet)
- [Contributing](#contributing)
- [License](#license)

## Getting Started

These instructions will guide you through setting up and using the Sibling Scorecard System.

### Prerequisites

To run this system, you need the following software/tools installed on your server:

- PHP (7.0 or higher)
- MySQL database
- Composer (for PHPExcel and PhpSpreadsheet libraries)
- Web server (e.g., Apache, Nginx)
- Web browser

### Installation

1. **Clone the Repository:**

   Clone this repository to your server:

   ```shell
   git clone https://github.com/yourusername/sibling-scorecard.git
   
2. **Database Setup:**

Create a MySQL database and import the database.sql file to set up the database schema.

3. **Install PHP Libraries:**
   Install the required PHP libraries using Composer:

   ```shell
   composer install

4. **Configure Database Connection:**
   Configure the database connection in db_connection.php with your database credentials.

5. **Server Configuration:**
   Ensure your server is correctly configured to serve PHP files.

6. **Access the Application:**
   Access the application through your web browser.

## Usage
**The Sibling Scorecard System provides the following main features:**

  **Adding a Sibling**
  You can add new siblings to the database. Simply enter the sibling's name.
  
  **Updating Scores**
  Update the scores for each sibling in categories such as punctuality, eating habits, and homework completion.

  **Importing Data**
  You can import data from an Excel file to quickly populate sibling information and scores.

## Using the Scoring Sheet
**Use the scoring sheet to assess each sibling's performance in various sections. The system calculates scores based on your inputs.
Features**

    *Easy management of sibling records and scores.
    Import data from Excel files for efficient data entry.
    Score calculation and assessment using a scoring sheet.
    Modern and user-friendly interface.

## Database Schema

The database schema is designed to be efficient and flexible, allowing easy expansion and customization of the system. The main table is named siblings and contains columns for sibling information and scores.
Scoring Sheet

The scoring sheet is a crucial part of this system, allowing you to assess siblings' performance in different categories. The scoring sheet is divided into sections, each with its own maximum points and scoring criteria. You can view the overall scores and determine if a sibling is "adolescent-friendly" and "client-friendly" based on the total scores.
Contributing

## Contributions

contributions to this project are welcome! You can contribute by reporting issues, suggesting enhancements, or submitting pull requests. Feel free to get involved and help improve the Sibling Scorecard System.

## License

This project is licensed under the MIT License - see the LICENSE file for details.


