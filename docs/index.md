## Table of Contents
1. [Installation](#installation)
2. [Setup Google API](#setup-google-api)
3. [Configuration](#configuration)

<a id="installation"></a>Installation
============
1. Go to the [Google API Console](https://console.cloud.google.com/projectselector2/apis/library){:target="_blank" rel="noopener"}.
2. Select an existing project, or create a new one by selecting **CREATE PROJECT**.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/01.png "Select Porject or Create Project")
3. Enter project name and click the **Create** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/02.png "Enter porject details")
4. In the Google API Library page, enter ***people*** in the search box.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/03.png "Enter porject details")
5. Select **Google People API** and proceed.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/04.png "Enter porject details")
6. From the *Google People API* page click on the **Enable** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/05.png "Enter porject details")
7. From the *API & Services* page, click on the **CREATE CREDENTIALS** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/06.png "Enter porject details")
8. From the *Credentials* tab, select **People API**, **User data** and click the **NEXT** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/07.png "Enter porject details")
9. From the *OAuth Consent Screen* tab, select **App information** and click the **SAVE AND CONTINUE** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/08.png "Enter porject details")
10. From the *Scopes* tab, click on the **ADD OR REMOVE SCOPES** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/09.png "Enter porject details")
11. From the *Update selected scopes* popup, enter ***userinfo*** in the filter search field and select the *userinfo* properties provided.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/10.png "Enter porject details")
12. From the *Update selected scopes* popup, enter ***openid*** in the filter search field and select the *openid* properties provided.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/11.png "Enter porject details")
13. After adding all the preferred scopes, click on the **UPDATE** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/12.png "Enter porject details")
14. From the *OAuth Client ID* tab;
a) Select **Web application** as the *Application type *
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/13.png "Enter porject details")
b) From the *Authorized JavaScript origins* and *Authorized redirect URIs*, click on the **ADD URI** buttons.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/14.png "Enter porject details")
c) Add the details as shown below.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/15.png "Enter porject details")

