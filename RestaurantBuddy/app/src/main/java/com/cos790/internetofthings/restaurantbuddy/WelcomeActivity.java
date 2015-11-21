package com.cos790.internetofthings.restaurantbuddy;

import android.app.Activity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ListView;

public class WelcomeActivity extends Activity {

    @Override
    protected void onCreate(Bundle state) {
        super.onCreate(state);
        setContentView(R.layout.activity_welcome);

        Integer[] images = {R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1};
        String[] values = new String[] {"My Place #1", "My Place #2", "My Place #3", "My Place #4", "My Place #5", "My Place #6", "My Place #7", "My Place #8", "My Place #9", "My Place #10" };

        CustomAdapter adapter = new CustomAdapter(this, values, images);

        ListView list = (ListView) findViewById(R.id.list);
        list.setAdapter(adapter);
    }

    //Add place onclick
    public void add_place(View view) {
        Log.v("INFO", "Add place button clicked!");
        // Intent intent = new Intent(this, LoginActivity.class);
        // startActivity(intent);
    }
}
