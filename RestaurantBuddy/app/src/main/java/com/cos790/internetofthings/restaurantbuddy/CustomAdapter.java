package com.cos790.internetofthings.restaurantbuddy;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

public class CustomAdapter extends ArrayAdapter<String> {

    private final Context context;
    private final String[] values;
    private final Integer[] images;

    public CustomAdapter(Context context, String[] values, Integer[] images) {
        super(context, R.layout.activity_welcome_item, values);
        this.context = context;
        this.values = values;
        this.images = images;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View rowView = inflater.inflate(R.layout.activity_welcome_item, parent, false);

        TextView textView = (TextView) rowView.findViewById(R.id.label);
        textView.setText(values[position]);

        ImageView imageView = (ImageView) rowView.findViewById(R.id.icon);
        imageView.setImageResource(images[position]);

        return rowView;
    }
}