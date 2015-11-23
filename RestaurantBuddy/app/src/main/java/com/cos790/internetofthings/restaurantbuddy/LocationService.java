package com.cos790.internetofthings.restaurantbuddy;

import android.app.IntentService;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.os.AsyncTask;
import android.support.v4.app.NotificationCompat;
import android.support.v4.app.NotificationCompat.Builder;
import android.util.Log;
import android.widget.Toast;

import com.google.android.gms.location.LocationClient;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class LocationService extends IntentService {


    private String TAG = this.getClass().getSimpleName();
    private String name;
    private static final String TAG_SUCCESS = "type";
    private static final String TAG_MESSAGE = "message";
    JSONParser jsonParser = new JSONParser();

    public LocationService() {
        super("Fused Location");
    }

    public LocationService(String name) {
        super("Fused Location");
        this.name = name;
    }

    @Override
    protected void onHandleIntent(Intent intent) {

        name = intent.getStringExtra(LoginActivity.ID);
        Location location = intent.getParcelableExtra(LocationClient.KEY_LOCATION_CHANGED);
        if(location !=null){
            Context context = getApplicationContext();
            Log.i(TAG, "onHandleIntent " + location.getLatitude() + "," + location.getLongitude());
            NotificationManager notificationManager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
            Builder noti = new NotificationCompat.Builder(this);
            noti.setContentTitle("Fused Location");
            noti.setContentText(location.getLatitude() + "," + location.getLongitude());
            noti.setSmallIcon(R.drawable.home_icon);

            Intent notificationIntent = new Intent(context, Delivery_man.class);
            notificationIntent.putExtra(LoginActivity.ID,name);

            notificationIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP
                    | Intent.FLAG_ACTIVITY_SINGLE_TOP);

            PendingIntent intents = PendingIntent.getActivity(context, 0, notificationIntent, 0);
            noti.setContentIntent(intents);

            notificationManager.notify(1234, noti.build());


            //NotificationManager notificationManager = (NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE);
            //Notification notification = new Notification(icon, message, when);


                String success;

                try {
                    List<NameValuePair> params = new ArrayList<NameValuePair>();
                    params.add(new BasicNameValuePair("delivery_man_id", name));


                    String lat = String.valueOf(location.getLatitude());
                    String lon = String.valueOf(location.getLongitude());
                    params.add(new BasicNameValuePair("lattitude",lat ));
                    params.add(new BasicNameValuePair("longitude", lon));

                    Log.d("request!", "starting");
                    JSONObject json = jsonParser.makeHttpRequest(
                            ApplicationConstants.APP_SERVER_submit_gps, "POST", params);

                    success = json.getString(TAG_SUCCESS);
                    if (success.equals("SUCCESS")) {

                        Log.v("INFO", "updated position");



                    }else{
                        Log.v("ERROR", json.getString(TAG_MESSAGE));

                    }
                } catch (JSONException e) {
                    Log.v("ERROR",e.toString());
                }


            }




    }

}
