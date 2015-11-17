package com.cos790.internetofthings.restaurantbuddy;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.PorterDuff;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.text.Html;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.facebook.AccessToken;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.FacebookSdk;
import com.facebook.GraphRequest;
import com.facebook.GraphResponse;
import com.facebook.login.LoginResult;
import com.facebook.login.widget.LoginButton;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.gcm.GoogleCloudMessaging;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;


public class MainActivity extends Activity {

    public final static String USERNAME = "com.cos790.internetofthings.restaurantbuddy.RegisterActivity.USERNAME";
    private TextView info;
    private LoginButton facebookLoginButton;
    private CallbackManager callbackManager;
    Context applicationContext;
    private ProgressDialog pDialog;
    GoogleCloudMessaging gcmObj;
    JSONParser jsonParser = new JSONParser();
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";

    private String numID;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        // Facebook login
        FacebookSdk.sdkInitialize(getApplicationContext());
        callbackManager = CallbackManager.Factory.create();
        setContentView(R.layout.activity_main);


        facebookLoginButton = (LoginButton)findViewById(R.id.facebook_login_button);
        facebookLoginButton.setReadPermissions("public_profile email");
        facebookLoginButton.registerCallback(callbackManager, new FacebookCallback<LoginResult>() {
            @Override
            public void onSuccess(LoginResult loginResult) {
                numID = loginResult.getAccessToken().getUserId();
                String message = "User ID: "
                        + loginResult.getAccessToken().getUserId()
                        + "\n" +
                        "Auth Token: "
                        + loginResult.getAccessToken().getToken();

                Log.v("INFO", message);

                if(AccessToken.getCurrentAccessToken() != null ) {

                    RequestData();
                }
            }

            @Override
            public void onCancel() {
                Log.v("INFO", "Login attempt canceled.");
            }
            @Override
            public void onError(FacebookException e) {
                Log.v("INFO", "Login attempt failed.");
            }
        });

        //Register text onTouch
        final TextView registerText = (TextView) findViewById(R.id.register_view_text);
        registerText.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                Log.v("INFO", "Register view text clicked!");
                register_view(view);
                return false;
            }
        });
    }

    // Login view
    public void login_view(View view) {
        Log.v("INFO", "Login view button clicked!");
        Intent intent = new Intent(this, LoginActivity.class);
        startActivity(intent);
    }

    // Register view
    public void register_view(View view) {
        Intent intent = new Intent(this, RegisterActivity.class);
        startActivity(intent);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        callbackManager.onActivityResult(requestCode, resultCode, data);
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
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
    }

    private String fullname,email,regID;
    private JSONObject json;
    public void RequestData(){
        GraphRequest request = GraphRequest.newMeRequest(AccessToken.getCurrentAccessToken(), new GraphRequest.GraphJSONObjectCallback() {
            @Override
            public void onCompleted(JSONObject object,GraphResponse response) {

                json = response.getJSONObject();
                try {
                    if(json != null){
                        fullname = json.getString("name");
                        if (json.getString("email").equals(null) || json.getString("email").equals(""))
                            email = json.getString("id");
                        else email = json.getString("email");


                        //GCM register
                        if (checkPlayServices()) {

                            // Register Device in GCM Server
                            new CreateUser().execute();
                        }

                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
        Bundle parameters = new Bundle();
        parameters.putString("fields", "id,name,link,email,picture");
        request.setParameters(parameters);
        request.executeAsync();
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
    @Override
    protected void onResume() {
        super.onResume();
        checkPlayServices();
    }

    /**
     * facebook create user
     *
     */
    class CreateUser extends AsyncTask<String, String, String> {

        /**
         * Before starting background thread Show Progress Dialog
         * */
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();


            pDialog = new ProgressDialog(MainActivity.this);
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
                String type = "2";
                params.add(new BasicNameValuePair("fullname", fullname));
                params.add(new BasicNameValuePair("email", email));
                params.add(new BasicNameValuePair("password", null));
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

                    intent.putExtra(USERNAME, email);
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
                Toast.makeText(MainActivity.this, file_url, Toast.LENGTH_LONG).show();
            }

        }

    }
}
