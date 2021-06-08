## Table of Contents
1. [Installation](#installation)
2. [Setup Google API](#setup-google-api)
3. [Configuration](#configuration)

<a id="installation"></a>Installation
============
**1.** Go to the [Google API Console](https://console.cloud.google.com/projectselector2/apis/library){:target="_blank" rel="noopener"}.

*********

**2.** Select an existing project, or create a new one by selecting **CREATE PROJECT**.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/01.png "Select Porject or Create Project")

*********

**3.** Enter project name and click the **Create** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/02.png "Create Project")

*********

**4.** In the Google API Library page, enter ***people*** in the search box.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/03.png)

*********

**5.** Select **Google People API** and proceed.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/04.png)

*********

**6.** From the *Google People API* page click on the **Enable** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/05.png)

*********

**7.** From the *API & Services* page, click on the **CREATE CREDENTIALS** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/06.png)

*********

**8.** From the *Credentials* tab, select **People API**, **User data** and click the **NEXT** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/07.png)

*********

**9.** From the *OAuth Consent Screen* tab, select **App information** and click the **SAVE AND CONTINUE** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/08.png)

*********

**10.** From the *Scopes* tab, click on the **ADD OR REMOVE SCOPES** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/09.png)

*********

**11.** From the *Update selected scopes* popup, enter ***userinfo*** in the filter search field and select the *userinfo* properties provided.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/10.png)

*********

**12.** From the *Update selected scopes* popup, enter ***openid*** in the filter search field and select the *openid* properties provided.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/11.png)

*********

**13.** After adding all the preferred scopes, click on the **UPDATE** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/12.png)

*********

**14.** From the *OAuth Client ID* tab;

**a)** Select **Web application** as the *Application type*.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/13.png)

**b)** From the *Authorized JavaScript origins* and *Authorized redirect URIs*, click on the **ADD URI** buttons.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/14.png)

**c)** Add the details as shown below.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/15.png)

*********

**15.** From the *Your Credentials* tab, youl will see your app's **Client ID** and then click the **DONE** button.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/16.png)

*********

**16.** From the *Credentials* page, copy the app's **Client ID** as shwon below.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/17.png)

*********

**17.** From the sidebar click on *OAuth consent screen*, choose whether to pusblih your app or leave it on testing mode.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/18.png)

*********

**18.** Enter your app's test users' emails.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/19.png)

*********

**19.** From the sidebar click on *Domain verification*, and proceed as instructed.
![alt text](https://raw.githubusercontent.com/Rodgath/DevResources/main/GOT-WP-Login-Register/console/20.png)

*********

**20.** DONE.
