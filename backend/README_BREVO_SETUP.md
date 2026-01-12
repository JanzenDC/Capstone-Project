# Brevo API Key Setup Guide

## Error: "API Key is not enabled"

If you're getting this error, it means your Brevo API key needs to be enabled in your Brevo dashboard.

## Steps to Fix:

1. **Go to Brevo Dashboard**
   - Visit: https://app.brevo.com/settings/keys/api
   - Log in to your Brevo account

2. **Check Your API Key**
   - Find the API key that matches the one in your `.env` file
   - The key should start with `xkeysib-`

3. **Enable Required Permissions**
   - Click on your API key or create a new one
   - Make sure the following permissions are enabled:
     - ✅ **Send emails** (Required for transactional emails)
     - ✅ **Access to Transactional API**

4. **Verify API Key in .env File**
   - Open `backend/.env`
   - Make sure the API key is correct and has no extra spaces:
     ```
     BREVO_API_KEY=xkeysib-your-actual-api-key-here
     ```

5. **Test the Configuration**
   - Access: `http://localhost/Capstone-Project/backend/api/test_env.php`
   - This will show if the .env file is being read correctly
   - Delete `test_env.php` after testing

## Common Issues:

- **API Key not found**: Make sure the key in `.env` matches exactly with the one in Brevo dashboard
- **Permissions not enabled**: The API key must have "Send emails" permission enabled
- **Wrong API key**: Make sure you're using a v3 API key (starts with `xkeysib-`)

## Need Help?

- Brevo Documentation: https://developers.brevo.com/
- Brevo Support: https://help.brevo.com/

