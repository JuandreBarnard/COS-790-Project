package com.cos790.internetofthings.restaurantbuddy;

import android.app.Activity;
import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.content.Intent;
import com.cos790.internetofthings.restaurantbuddy.LoginActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class WelcomeActivity extends Activity {

    private ProgressDialog pDialog;
    JSONParser jsonParser = new JSONParser();
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    private String ID;
    //private EditText user, pass;
    //private Button mSubmit,mRegister;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_welcome);

        Intent intent = getIntent();
         ID = intent.getStringExtra(LoginActivity.ID);

        //get data from database
        new AttemptRestSearch().execute();

        //show detail of user
        /*final TextView result = (TextView) findViewById(R.id.result);
        result.setText(username);*/

        // check if GPS enabled
        /*GPSTracker gpsTracker = new GPSTracker(this);

        if (gpsTracker.getIsGPSTrackingEnabled())
        {
            String stringLatitude = String.valueOf(gpsTracker.latitude);
            textview = (TextView)findViewById(R.id.fieldLatitude);
            textview.setText(stringLatitude);

            String stringLongitude = String.valueOf(gpsTracker.longitude);
            textview = (TextView)findViewById(R.id.fieldLongitude);
            textview.setText(stringLongitude);

            String country = gpsTracker.getCountryName(this);
            textview = (TextView)findViewById(R.id.fieldCountry);
            textview.setText(country);

            String city = gpsTracker.getLocality(this);
            textview = (TextView)findViewById(R.id.fieldCity);
            textview.setText(city);

            String postalCode = gpsTracker.getPostalCode(this);
            textview = (TextView)findViewById(R.id.fieldPostalCode);
            textview.setText(postalCode);

            String addressLine = gpsTracker.getAddressLine(this);
            textview = (TextView)findViewById(R.id.fieldAddressLine);
            textview.setText(addressLine);
        }
        else
        {
            // can't get location
            // GPS or Network is not enabled
            // Ask user to enable GPS/network in settings
            gpsTracker.showSettingsAlert();
        }*/
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_welcome, menu);
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

    class AttemptRestSearch extends AsyncTask<String, String, String> {

        /**
         * Before starting background thread Show Progress Dialog
         */
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(WelcomeActivity.this);
            pDialog.setMessage("Retrieving list...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            // TODO Auto-generated method stub
            // Check for success tag
            String success;


            try {
                // Building Parameters
                List<NameValuePair> params = new ArrayList<NameValuePair>();
                //params.add(new BasicNameValuePair("userId", ID));

                Log.d("request!", "starting");
                // getting product details by making HTTP request
                JSONObject json = jsonParser.makeHttpRequest(
                        ApplicationConstants.APP_SERVER_all_restaurant, "POST", params);

                // check your log for json response
                Log.d("List attempt", json.toString());

                // json success tag
                success = json.getString(TAG_SUCCESS);
                if (success.equals("SUCCESS")) {
                    /*Intent intent = new Intent(getBaseContext(), WelcomeActivity.class);
                    intent.putExtra(USERNAME, username);

                    startActivity(intent);
                    Log.d("Login Successful!", json.toString());
                    //Intent i = new Intent(WelcomeActivity.this, ReadComments.class);
                    finish();*/
                    //startActivity(i);
                    JSONArray data = json.getJSONArray("data");

                    for(int i=0;i<data.length();i++)
                    {
                        JSONObject b = data.getJSONObject(i);
                        /*String id = b.getString("id");
                        Log.i(".......",id);
                        //JSONObject latitude = b.getJSONObject("latitude");
                        String latitude = b.getString("lattitude");
                        Log.i(".......",latitude);*/
                    }
                    return json.getString(TAG_SUCCESS);
                } else {
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
         **/
        protected void onPostExecute(String file_url) {
            // dismiss the dialog once product deleted
            pDialog.dismiss();
            if (file_url != null) {
                Toast.makeText(WelcomeActivity.this, file_url, Toast.LENGTH_LONG).show();
            }

        }
    }

}
