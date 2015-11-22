package com.cos790.internetofthings.restaurantbuddy;

import android.app.Activity;
import android.content.Intent;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;

public class WelcomeActivity extends Activity {

    Context applicationContext;
    private ProgressDialog pDialog;
    private CustomAdapter adapter;
    private ListView list;
    JSONParser jsonParser = new JSONParser();
    private JSONArray data;
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    private String ID;
    public final static String SELECTED_RESTAURANT = "com.cos790.internetofthings.restaurantbuddy.WelcomeActivity.SELECTED_RESTAURANT";

    @Override
  protected void onCreate(Bundle state) {
      super.onCreate(state);
      setContentView(R.layout.activity_welcome);
      Intent intent = getIntent();
      ID = intent.getStringExtra(LoginActivity.ID);

      applicationContext = getApplicationContext();
      list = (ListView) findViewById(R.id.list);
      new AttemptRestSearch().execute();
  }
    @Override
    public void onRestart() {
        super.onRestart();
        //Refresh your stuff here
        list = (ListView) findViewById(R.id.list);
        new AttemptRestSearch().execute();
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
                List<NameValuePair> params = new ArrayList<>();
                params.add(new BasicNameValuePair("id", ID));

                Log.d("request!", "starting");
                // getting product details by making HTTP request

                // TODO: change back to user_places
                JSONObject json = jsonParser.makeHttpRequest(
                        ApplicationConstants.APP_SERVER_user_places, "POST", params);

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
                    data = json.getJSONArray("data");
                    List<String> ids = new LinkedList<>();
                    List<String> images = new LinkedList<>();
                    List<String> values = new LinkedList<>();
                    for(int i=0;i<data.length();i++)
                    {

                        JSONObject b = data.getJSONObject(i);

                        //byte[] object = (byte[]) b.get("logo");

                        ids.add(b.getString("id"));

                        images.add(b.getString("logo"));

                        values.add(b.getString("restaurantName"));
                        /*String id = b.getString("id");
                        Log.i(".......",id);
                        //JSONObject latitude = b.getJSONObject("latitude");
                        String latitude = b.getString("lattitude");
                        Log.i(".......",latitude);*/
                    }
                    //listofurls = image_urls.toArray(new String[image_urls.size()]);
                    String[] id = ids.toArray(new String[ids.size()]);
                    String[] a =  values.toArray(new String[values.size()]);
                    String[] img =  images.toArray(new String[images.size()]);
                    adapter = new CustomAdapter(applicationContext, id, a, img);

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
            // Dismiss the dialog once product deleted
            pDialog.dismiss();
            if (file_url != null||file_url.equals("SUCCESS")) {
                Toast.makeText(WelcomeActivity.this, file_url, Toast.LENGTH_LONG).show();
            }
            if(adapter != null) {
                list.setAdapter(adapter);
            }

            // List item onclick
            list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long arg) {
                    String id = ((TextView) view.findViewById(R.id.id)).getText().toString();
                    JSONObject selected_restaurant = null;

                    try {
                        for (int i = 0; i < data.length(); i++) {

                            JSONObject b = data.getJSONObject(i);
                            if (b.getString("id").equals(id)) {
                                selected_restaurant = b;
                                break;
                            }
                        }
                    } catch (Exception e) {
                        Log.v("ERROR", e.toString());
                    }

                    Log.v("INFO", "Selected restaurant: " + selected_restaurant.toString());
                    details_view(selected_restaurant);

                }
            });
        }
    }

    //Add place activity
    public void add_place_view(View view) {
        Log.v("INFO", "Add place button clicked!");
        Intent intent = new Intent(this, AddPlaceActivity.class);
        intent.putExtra(LoginActivity.ID, ID);
        startActivity(intent);

    }

    // Details activity
    public void details_view(JSONObject selected_item) {
        Intent intent = new Intent(this, DetailsActivity2.class);
        intent.putExtra(SELECTED_RESTAURANT, selected_item.toString());
        intent.putExtra(LoginActivity.ID, ID);
        startActivity(intent);
    }
    
}
