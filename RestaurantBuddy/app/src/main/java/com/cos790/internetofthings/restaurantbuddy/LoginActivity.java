package com.cos790.internetofthings.restaurantbuddy;

import android.content.Context;
import android.content.Intent;
import android.os.Looper;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicHeader;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.protocol.HTTP;
import org.json.JSONObject;

import java.io.InputStream;


public class LoginActivity extends ActionBarActivity {

    public final static String USERNAME = "com.cos790.internetofthings.restaurantbuddy.LoginActivity.USERNAME";
    public final static String PASSWORD = "com.cos790.internetofthings.restaurantbuddy.LoginActivity.PASSWORD";
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

        Boolean result = sendJson(username, password);

        if (result) {
            Intent intent = new Intent(this, WelcomeActivity.class);
            intent.putExtra(USERNAME, username);
            intent.putExtra(PASSWORD, username);
            startActivity(intent);
        }
    }

    // Authenticate
    // TODO: post(json)
    public boolean authenticate(String username, String password) {

        String json = "{\" type \": \" SUCCESS \", \"message\": \"Successfully logged in!\", \" data \": { \"username\" " + username + ", \"passowrd\": " + password + " }}";
        return true;
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
    Context applicationContext;
    protected boolean sendJson(final String email, final String pwd) {
        applicationContext = getApplicationContext();
        Thread t = new Thread() {

            public void run() {
                Looper.prepare(); //For Preparing Message Pool for the child Thread
                HttpClient client = new DefaultHttpClient();
                HttpConnectionParams.setConnectionTimeout(client.getParams(), 10000); //Timeout Limit
                HttpResponse response;
                JSONObject json = new JSONObject();

                try {
                    HttpPost post = new HttpPost(ApplicationConstants.APP_SERVER_URL_USER);
                    json.put("email", email);
                    json.put("password", pwd);
                    StringEntity se = new StringEntity( json.toString());
                    se.setContentType(new BasicHeader(HTTP.CONTENT_TYPE, "application/json"));
                    post.setEntity(se);
                    response = client.execute(post);

                    /*Checking response */
                    if(response!=null){
                        InputStream in = response.getEntity().getContent(); //Get the data in the entity
                        Toast.makeText(applicationContext,
                                "user has been submitted",
                                Toast.LENGTH_LONG).show();
                    }

                } catch(Exception e) {
                    e.printStackTrace();

                    //createDialog("Error", "Cannot Estabilish Connection");
                }

                Looper.loop(); //Loop in the message queue
            }
        };

        t.start();
        return true;
    }

}
