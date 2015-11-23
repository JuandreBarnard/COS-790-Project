package com.cos790.internetofthings.restaurantbuddy;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Environment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.io.File;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;

public class CustomAdapter extends ArrayAdapter<String> {

    private final Context context;
    private final String[] ids;
    private final String[] values;
    private final String[] images;
    private final String[] addresses;

    public CustomAdapter(Context context, String[] ids, String[] values, String[] images, String[] addresses) {
        super(context, R.layout.activity_welcome_item, values);
        this.context = context;
        this.ids = ids;
        this.values = values;
        this.addresses = addresses;
        this.images = images;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View rowView = inflater.inflate(R.layout.activity_welcome_item, parent, false);

        TextView id = (TextView) rowView.findViewById(R.id.id);
        id.setText(ids[position]);

        TextView label = (TextView) rowView.findViewById(R.id.label);
        label.setText(values[position]);

        TextView address = (TextView) rowView.findViewById(R.id.address);
        address.setText(addresses[position]);

        ImageView imageView = (ImageView) rowView.findViewById(R.id.icon);
        new ImageLoadTask(images[position],imageView).execute();
        //setImageResource();

        return rowView;
    }
    public class ImageLoadTask extends AsyncTask<Void, Void, Bitmap> {

        private String url;
        private ImageView imageView;

        public ImageLoadTask(String url, ImageView imageView) {
            this.url = url;
            this.imageView = imageView;
        }

        @Override
        protected Bitmap doInBackground(Void... params) {
           if (!url.equals("")||!url.equals(null)){
            try {
                URL urlConnection = new URL(url);
                HttpURLConnection connection = (HttpURLConnection) urlConnection
                        .openConnection();
                connection.setDoInput(true);
                connection.connect();
                InputStream input = connection.getInputStream();
                Bitmap myBitmap = BitmapFactory.decodeStream(input);
                return myBitmap;
            } catch (Exception e) {
                e.printStackTrace();
            }
           }

            //IV.setImageBitmap(bMap);
            return null;
        }

        @Override
        protected void onPostExecute(Bitmap result) {
            super.onPostExecute(result);

            if(result ==null)
            {
                imageView.setImageResource(R.drawable.default_logo);
            }
            else {
                imageView.setImageBitmap(result);
            }
        }

    }
}