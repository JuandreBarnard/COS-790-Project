package com.cos790.internetofthings.restaurantbuddy;

/*import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;*/
import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

//import org.json.JSONObject;

public class LoginActivity extends Activity implements OnClickListener {

    /*public final static String USERNAME = "com.cos790.internetofthings.restaurantbuddy.LoginActivity.USERNAME";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
    }

    // Login
    public void login(View view) {
        Log.v("INFO", "Login submit button clicked!");

        EditText usernameEditText = (EditText) findViewById(R.id.username);
        String username = usernameEditText.getText().toString();

        EditText passwordEditText = (EditText) findViewById(R.id.password);
        String password = passwordEditText.getText().toString();

        Boolean result = authenticate(username, password);

        if (result) {
            Intent intent = new Intent(this, WelcomeActivity.class);
            intent.putExtra(USERNAME, username);
            startActivity(intent);
        }
    }

    // Authenticate
    // TODO: post(json)
    public boolean authenticate(String username, String password) {
        JSONObject params = new JSONObject();
        String json = "{\" type \": \" SUCCESS \", \"message\": \"Successfully logged in!\", \" data \": { \"username\" " + username + ", \"passowrd\": " + password + " }}";
*/
        /*ApplicationRequest ar = new ApplicationRequest();
        ar.server_request(params);*/

        /*return true;
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_login, menu);
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
    */

    public final static String USERNAME = "com.cos790.internetofthings.restaurantbuddy.RegisterActivity.USERNAME";
    public final static String ID = "com.cos790.internetofthings.restaurantbuddy.RegisterActivity.ID";
    private ProgressDialog pDialog;
    JSONParser jsonParser = new JSONParser();
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    private EditText user, pass;
    private Button mSubmit,mRegister;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        // TODO Auto-generated method stub
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        //setup input fields
        user = (EditText)findViewById(R.id.username);
        pass = (EditText)findViewById(R.id.password);

        //setup buttons
        mSubmit = (Button)findViewById(R.id.login_button_submit);
        //mRegister = (Button)findViewById(R.id.register);

        //register listeners
        mSubmit.setOnClickListener(this);
        //mRegister.setOnClickListener(this);

    }
    String username;
    String password;
    @Override
    public void onClick(View v) {
        // TODO Auto-generated method stub
       /* switch (v.getId()) {
            case R.id.login:*/
        username = user.getText().toString();
        password = pass.getText().toString();

            new AttemptLogin().execute();

                //break;
            /*case R.id.register:
                Intent i = new Intent(this, RegisterActivity.class);
                startActivity(i);
                break;

            default:
                break;}*/

    }

    class AttemptLogin extends AsyncTask<String, String, String> {

        /**
         * Before starting background thread Show Progress Dialog
         * */
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(LoginActivity.this);
            pDialog.setMessage("Attempting login...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            // TODO Auto-generated method stub
            // Check for success tag
            String success;

            if(!Utility.validate(username)) {
             return "Login Failure! Email format is incorrect";
            }
            if(password.equals("")||password.equals(null)) {
                return "Login Failure! Password is empty";
            }
            try {
                // Building Parameters
                List<NameValuePair> params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair("email", username));
                params.add(new BasicNameValuePair("password", password));

                Log.d("request!", "starting");
                // getting product details by making HTTP request
                JSONObject json = jsonParser.makeHttpRequest(
                        ApplicationConstants.APP_SERVER_LOGIN, "POST", params);

                // check your log for json response
                Log.d("Login attempt", json.toString());

                // json success tag
                success = json.getString(TAG_SUCCESS);
                if (success.equals("SUCCESS")) {
                    JSONObject data = json.getJSONObject("data");
                    Intent intent = new Intent(getBaseContext(), WelcomeActivity.class);
                    intent.putExtra(ID, data.getString("id"));
                    //intent.putExtra(USERNAME, username);
                    startActivity(intent);
                    Log.d("Login Successful!", json.toString());
                    //Intent i = new Intent(WelcomeActivity.this, ReadComments.class);
                    finish();
                    //startActivity(i);
                    return json.getString(TAG_SUCCESS);
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
                Toast.makeText(LoginActivity.this, file_url, Toast.LENGTH_LONG).show();
            }

        }

    }
}
