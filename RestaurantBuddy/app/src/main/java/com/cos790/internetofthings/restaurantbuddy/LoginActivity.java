package com.cos790.internetofthings.restaurantbuddy;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;

import org.json.JSONObject;

public class LoginActivity extends ActionBarActivity {

    public final static String USERNAME = "com.cos790.internetofthings.restaurantbuddy.LoginActivity.USERNAME";

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

        ApplicationRequest ar = new ApplicationRequest();
        ar.server_request(params);

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
}
