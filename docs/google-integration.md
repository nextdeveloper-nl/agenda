
# Suggestion for Integrating Google Services into the Agenda Module


## Steps to Integrate Google Calendar

1. Authentication

We already have OAuth 2.0 authentication implemented in our application. Below are the steps to extend it for Google Calendar:
- Handling Authentication Tokens:
	- Google authentication tokens are valid for 60 minutes. Tokens need to be refreshed before expiration.
	- A scheduled task should be configured to automatically refresh tokens every 50 minutes using the refresh token provided during the initial authentication.
- Dynamic Scopes Management:
	- Authentication scopes should be stored dynamically in the database to allow future flexibility.
	- If new scopes are added, users with an existing valid token must be prompted to re-authenticate to obtain a new token with the updated scopes.


2. Fetching Calendars

Once authenticated, the next step is to retrieve the user’s calendars from Google. There are two possible approaches:
- Fetch All Calendars:
	- Add a button in the user interface (UI) to fetch all calendars. These calendars will be stored in the database with a default enable_sync status set to false.
	- 	Users can enable synchronization for specific calendars via the UI.
- Fetch Calendars Individually:
	- Add a button in the UI allowing the user to manually select a specific calendar for synchronization. The selected calendar will be stored in the database with enable_sync set to true.

3. Event Synchronization

After fetching the calendars, synchronize the associated events. Here are the steps:
- Set Up a Synchronization Schedule:
	- Create a console command to run every 10 minutes and synchronize user events.
- Required Checks:
	- Verify if the user has any calendars enabled for synchronization.
	- 	Ensure the user’s authentication token is valid before proceeding with synchronization.
- Event Processing:
	- Synchronize events that have been added, updated, or deleted in the connected calendars.

