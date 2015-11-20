package com.cos790.internetofthings.restaurantbuddy;

import android.app.ListActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ListView;

public class WelcomeActivity extends ListActivity {

    public void onCreate(Bundle icicle) {
        super.onCreate(icicle);

        Integer[] images = {R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1, R.drawable.place_icon_2, R.drawable.place_icon_1};
        String[] values = new String[] {"My Place #1", "My Place #2", "My Place #3", "My Place #4", "My Place #5", "My Place #6" };

        CustomAdapter adapter = new CustomAdapter(this, values, images);
        setListAdapter(adapter);
    }

    @Override
    // Item onclick event
    protected void onListItemClick(ListView l, View v, int position, long id) {
        String item = (String) getListAdapter().getItem(position);
        Log.v("INFO", "Item clicked!" + item);
    }
}
