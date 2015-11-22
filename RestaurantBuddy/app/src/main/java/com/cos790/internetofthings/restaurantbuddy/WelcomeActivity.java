package com.cos790.internetofthings.restaurantbuddy;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.ListView;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.sql.Blob;
import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;

public class WelcomeActivity extends Activity {

    Context applicationContext;
    private ProgressDialog pDialog;
    private CustomAdapter adapter;
    private ListView list;
    JSONParser jsonParser = new JSONParser();
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    private String ID;
    @Override
    protected void onCreate(Bundle state) {
        super.onCreate(state);
        setContentView(R.layout.activity_welcome);
        Intent intent = getIntent();
        ID = intent.getStringExtra(LoginActivity.ID);

        //Integer[] images = {R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1};
        //String[] values = new String[] {"My Place #1", "My Place #2", "My Place #3", "My Place #4", "My Place #5", "My Place #6", "My Place #7", "My Place #8", "My Place #9", "My Place #10" };
        applicationContext = getApplicationContext();
        list = (ListView) findViewById(R.id.list);
        new AttemptRestSearch().execute();




    }

    //Add place onclick
    public void add_place(View view) {
        Log.v("INFO", "Add place button clicked!");
        // Intent intent = new Intent(this, LoginActivity.class);
        // startActivity(intent);
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
                    List<String> images = new LinkedList<>();
                    List<String> values = new LinkedList<>();
                    for(int i=0;i<data.length();i++)
                    {

                        JSONObject b = data.getJSONObject(i);


                        //byte[] object = (byte[]) b.get("logo");

                        images.add(b.getString("logo"));

                        values.add(b.getString("restaurantName"));
                        /*String id = b.getString("id");
                        Log.i(".......",id);
                        //JSONObject latitude = b.getJSONObject("latitude");
                        String latitude = b.getString("lattitude");
                        Log.i(".......",latitude);*/
                    }

                    adapter = new CustomAdapter(applicationContext,(String[]) values.toArray(), (String[]) images.toArray());

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
            if(adapter != null)
                list.setAdapter(adapter);
        }
    }
}
