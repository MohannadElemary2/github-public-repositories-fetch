# Public GitHub Repositories Fetcher

We want to get most popular github repositories with programming language filter, creation date filter and ability to determine page size. There are two methods to implement that and each one has its pros and cons.

**Postman Collection:**
https://documenter.getpostman.com/view/8868758/Tzz7QJm3


## Method #1: Calling The GitHub API Directly Each Time Our API is Called
We can simply call Github's API when anyone wants to call our API. This is found in our endpoint `/api/v1/repositories`

**Advanatages:**
- Less coding.
- Applicable with public web services.

**Disatvantages:**
- A lot of network calls.
- Throttling issue with the provider.
- Our API could be blacklisted.

## Method #2: Syncing Github's Repositories Data To Our Database And Then Get The Data From it
We can sync the data from github everyday using a cron job. Everyday we fetch all the repositories that have been changed "updated" the day before.  This is found in our endpoint `/api/v2/repositories`

**Advanatages:**
- No throttling issues from the provider.
- Having the data on premise gives us flexibility to manipulate it and even analyse it.

**Disatvantages:**
- We will not get today's updates untill the next day.
- To many operations in the cron job.
- A lot of data stored in database that means a lot of resources needed.

## How To Use / Setup
- Clone repo to your device.
- Run `composer install` in the project.
- Create new database for the project.
- Enter your database conenction and name in the .env file.
- Run `php artisan migrate`.
- Open Postman and try the APIs.