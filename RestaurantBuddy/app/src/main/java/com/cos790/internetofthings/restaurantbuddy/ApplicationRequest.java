package com.cos790.internetofthings.restaurantbuddy;

import android.app.ProgressDialog;
import android.content.Context;
import android.widget.Toast;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;

import org.apache.http.Header;
import org.json.JSONObject;

public class ApplicationRequest {

    Context applicationContext;
    ProgressDialog prgDialog;

    public JSONObject server_request(JSONObject params) {

        prgDialog.show();

        //params.put(params);
        // Make RESTful webservice call using AsyncHttpClient object

        AsyncHttpClient client = new AsyncHttpClient();

        client.post(ApplicationConstants.APP_SERVER_URL, null/**Parameters*/,
            new AsyncHttpResponseHandler() {
                // When the response returned by REST has Http
                // response code '200'

                @Override
                public void onSuccess(int statusCode, Header[] headers, byte[] response) {
                    // Hide Progress Dialog
                    prgDialog.hide();

                    if (prgDialog != null) {
                        prgDialog.dismiss();
                    }

                    Toast.makeText(applicationContext,
                            "Reg Id shared successfully with Web App ",
                            Toast.LENGTH_LONG).show();
            /*Intent i = new Intent(applicationContext,
                    HomeActivity.class);
                    i.putExtra("regId", regId);
                    startActivity(i);
                    finish();*/
                }

                // When the response returned by REST has Http
                // response code other than '200' such as '404',
                // '500' or '403' etc
                @Override
                public void onFailure(int statusCode, Header[] headers, byte[] errorResponse, Throwable e) {
                    // Hide Progress Dialog
                    prgDialog.hide();
                    if (prgDialog != null) {
                        prgDialog.dismiss();
                    }
                    // When Http response code is '404'
                    if (statusCode == 404) {
                        Toast.makeText(applicationContext,
                                "Requested resource not found",
                                Toast.LENGTH_LONG).show();
                    }
                    // When Http response code is '500'
                    else if (statusCode == 500) {
                        Toast.makeText(applicationContext,
                                "Something went wrong at server end",
                                Toast.LENGTH_LONG).show();
                    }
                    // When Http response code other than 404, 500
                    else {
                        Toast.makeText(
                                applicationContext,
                                "Unexpected Error occured! [Most common Error: Device might "
                                        + "not be connected to Internet or remote server is not up and running], check for other errors as well",
                                Toast.LENGTH_LONG).show();
                    }
                }
            });

        return null;

    }

}
