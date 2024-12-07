### **Precautions to Take While Using the Dashboard**

1. **Internet Connectivity**:
   - Ensure you have a stable and active internet connection. The dashboard relies on cloud-based authentication and dynamic data fetching, which require internet access.

2. **Login Requirement**:
   - Users must log in using valid credentials (Google, Yahoo, Microsoft, or manually created accounts).
   - Unauthorized access to the dashboard is not allowed.

3. **Password Policy**:
   - When creating a new account, ensure the password is **at least 8 characters long** for enhanced security.
   - Avoid using easily guessable passwords (e.g., "12345678", "password", etc.).

4. **Browser Compatibility**:
   - Use a modern web browser like Google Chrome, Mozilla Firefox, or Microsoft Edge for the best experience.
   - Avoid older browsers that might not support the latest JavaScript libraries like D3.js or Chart.js.

5. **Data Input and Upload**:
   - When updating profiles or uploading profile images:
     - Ensure the image size is reasonable (less than 2MB).
     - Provide accurate details to avoid data inconsistencies.

6. **Session Management**:
   - Do not share your login credentials with others.
   - Log out after using the dashboard, especially on public or shared devices.

7. **Data Filters**:
   - Use valid inputs in filters (e.g., selecting available years, valid topics, and regions). Invalid inputs may result in errors or no data display.

8. **Third-Party Authentication**:
   - If signing in via Google, Yahoo, or Microsoft, ensure that your third-party account is active and accessible.

**By adhering to these precautions, you can ensure a smooth and secure experience while using the dashboard.**

**File Structure**
- assets
  - css
  - fonts
  - img
  - js
  - scss
- pages
  -upload
  - index.php
  - dbconn.php
  - footer.php
  - navbar.php
  - profile.php
  - retriveAllData.php
  - retriveData.php
  - retriveTable.php
  - retriveRegions.php
  - saveProfile.php
  - sidebar.php
  - sign-in.php
  - sign-up.php
  - tables.php
  - updateSession.php
  - upload.php
- table
  - insights_data.sql
  - user_imageuploads.sql
  - user_profiles.sql
- readme.md

  