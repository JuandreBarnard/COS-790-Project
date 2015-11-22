package com.cos790.internetofthings.restaurantbuddy;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

public class DetailsActivity extends ActionBarActivity {

    private String ID;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        // Intent intent = getIntent();
        // String item_id = intent.getStringExtra(AddPlaceActivity.ITEM_ID);
        // String item_id = intent.getStringExtra(WelcomeActivity.ITEM_ID);

        // TODO: get item by id

        Intent intent = getIntent();
        ID = intent.getStringExtra(LoginActivity.ID);

    }

    // Add place button click
    public void add_place(View view) {
        Log.v("INFO", "Add button clicked! ");
    }
}
