package com.cos790.internetofthings.restaurantbuddy;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.preference.PreferenceActivity;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import org.apache.http.Header;
import org.json.JSONObject;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;

public class RegisterActivity extends ActionBarActivity {

    public final static String USERNAME = "com.cos790.internetofthings.restaurantbuddy.RegisterActivity.USERNAME";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
    }

    // Register
    public void register(View view) {
        Log.v("INFO", "Register submit button clicked!");

        EditText usernameEditText = (EditText) findViewById(R.id.username);
        String username = usernameEditText.getText().toString();

        EditText emailEditText = (EditText) findViewById(R.id.email);
        String email = emailEditText.getText().toString();

        EditText passwordEditText = (EditText) findViewById(R.id.password);
        String password = passwordEditText.getText().toString();

        EditText passwordConfirmEditText = (EditText) findViewById(R.id.password_confirm);
        String password_confirm = passwordConfirmEditText.getText().toString();

        Boolean result = create_user(username, email, password, password_confirm);

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
        JSONObject params = new JSONObject();

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
    }
}
