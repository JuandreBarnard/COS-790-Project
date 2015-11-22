package com.cos790.internetofthings.restaurantbuddy;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

public class AddPlaceActivity extends ActionBarActivity {

    public final static String ITEM_ID = "com.cos790.internetofthings.restaurantbuddy.AddPlaceActivity.ITEM_ID";
    private String ID;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_place);

        // TODO: Fix (should work like the WelcomeActivity)
        String[] images = {};
        String[] values = new String[] {};
        CustomAdapter adapter = new CustomAdapter(this, values, images);
        ListView list = (ListView) findViewById(R.id.list);
        list.setAdapter(adapter);

        Intent intent = getIntent();
        ID = intent.getStringExtra(LoginActivity.ID);

        // List item onclick
        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Log.v("INFO", "List item clicked! At: " + position);
                details_view(position);
            }
        });
    }

    // Details activity
    public void details_view(int restaurant_id) {
        Intent intent = new Intent(this, DetailsActivity.class);
        intent.putExtra(ITEM_ID, restaurant_id);
        intent.putExtra(LoginActivity.ID, ID);
        startActivity(intent);
    }

}