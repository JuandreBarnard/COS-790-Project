package com.cos790.internetofthings.restaurantbuddy;

/*import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.EditText;*/
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;

import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.gcm.GoogleCloudMessaging;

public class RegisterActivity extends Activity implements OnClickListener {

    public final static String USERNAME = "com.cos790.internetofthings.restaurantbuddy.RegisterActivity.USERNAME";
    GoogleCloudMessaging gcmObj;
    private EditText usernameEditText, emailEditText,passwordEditText,passwordConfirmEditText;
    private String username,email,password,password_confirm,regID;
    private Button mRegister;
    Context applicationContext;
    private ProgressDialog pDialog;
    JSONParser jsonParser = new JSONParser();
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        applicationContext = getApplicationContext();
        Log.v("INFO", "Register submit button clicked!");

        usernameEditText = (EditText) findViewById(R.id.username);
        emailEditText = (EditText) findViewById(R.id.email);
        passwordEditText = (EditText) findViewById(R.id.password);
        passwordConfirmEditText = (EditText) findViewById(R.id.password_confirm);


            /*String username = usernameEditText.getText().toString();
            String email = emailEditText.getText().toString();
            String password = passwordEditText.getText().toString();*/



        //Boolean result = create_user(username, email, password, password_confirm);

        mRegister = (Button)findViewById(R.id.register);
        mRegister.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        // TODO Auto-generated method stub
        username = usernameEditText.getText().toString();
        email = emailEditText.getText().toString();
        password = passwordEditText.getText().toString();
        password_confirm = passwordConfirmEditText.getText().toString();


        new CreateUser().execute();

    }

    class CreateUser extends AsyncTask<String, String, String> {

        /**
         * Before starting background thread Show Progress Dialog
         * */
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();


            pDialog = new ProgressDialog(RegisterActivity.this);
            pDialog.setMessage("Creating User...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            // TODO Auto-generated method stub
            // Check for success tag
            String success;
            if(!password_confirm.equals(password)) {
                Log.d("Login Failure!","Password doesn't match");
                return "Login Failure! Password doesn't match";// "Creation failed, Password doesn't match";
            }
            if (checkPlayServices()) {
                try {
                    if (gcmObj == null) {
                        gcmObj = GoogleCloudMessaging.getInstance(applicationContext);
                    }
                    regID = gcmObj.register(ApplicationConstants.GOOGLE_PROJ_ID);
                    //msg = "Registration ID :" + regId;

                } catch (IOException ex) {
                    Log.d("Error :", ex.getMessage());
                    ex.printStackTrace();
                    return null;
                }
            }
            else return "This device doesn't support Play services, App will not work normally";

            try {
                // Building Parameters
                List<NameValuePair> params = new ArrayList<NameValuePair>();
                String type = "1";
                params.add(new BasicNameValuePair("fullname", username));
                params.add(new BasicNameValuePair("email", email));
                params.add(new BasicNameValuePair("password", password));
                params.add(new BasicNameValuePair("type", type));
                params.add(new BasicNameValuePair("gcmregid", regID));


                Log.d("request!", "starting");

                //Posting user data to script
                JSONObject json = jsonParser.makeHttpRequest(ApplicationConstants.APP_SERVER_REGISTER, "POST", params);

                // full json response
                Log.d("Login attempt", json.toString());

                // json success element

                success = json.getString(TAG_SUCCESS);
                if (!success.equals("SUCCESS")) {

                    Log.d("User Created!", json.toString());
                    Intent intent = new Intent(getBaseContext(), WelcomeActivity.class);
                    intent.putExtra(USERNAME, username);
                    startActivity(intent);
                    finish();
                    return json.getString(TAG_MESSAGE);
                }else{
                    Log.d("Login Failure!", json.getString(TAG_MESSAGE));
                    return json.getString(TAG_MESSAGE);

                }
            } catch (JSONException e) {
                e.printStackTrace();
            }

            return null;

        }
        /**
         * After completing background task Dismiss the progress dialog
         * **/
        protected void onPostExecute(String file_url) {
            // dismiss the dialog once product deleted
            pDialog.dismiss();
            if (file_url != null){
                Toast.makeText(RegisterActivity.this, file_url, Toast.LENGTH_LONG).show();
            }

        }

    }
    private final static int PLAY_SERVICES_RESOLUTION_REQUEST = 9000;
    private boolean checkPlayServices() {
        int resultCode = GooglePlayServicesUtil
                .isGooglePlayServicesAvailable(this);
        if (resultCode != ConnectionResult.SUCCESS) {
            if (GooglePlayServicesUtil.isUserRecoverableError(resultCode)) {
                GooglePlayServicesUtil.getErrorDialog(resultCode, this,
                        PLAY_SERVICES_RESOLUTION_REQUEST).show();
            } else {

                //finish();
            }
            return false;
        } else {

        }
        return true;
    }


/*

    // Register
    public void register(View view) {


        if (result) {
            Intent intent = new Intent(this, WelcomeActivity.class);
            intent.putExtra(USERNAME, username);
            startActivity(intent);
        }
    }

    // Create user
    // TODO: post(json)
    public boolean create_user(String username, String email, String password, String password_confirm) {
        // String json = "{\" type \": \" SUCCESS \", \"message\": \"Successfully registered!\", \" data \": { \"username\" " + username + ", \"password\": " + password + ", \"password_confirm\": \"" + password_confirm + "\" }}";


        ApplicationRequest ar = new ApplicationRequest();
        ar.server_request(params);

        return true;
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_register, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }*/
}
