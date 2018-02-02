package com.example.alejandro.florfeliz;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.Spinner;
import android.widget.Toast;


import org.json.JSONArray;
import org.json.JSONException;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.List;

import android.os.Handler;
import android.os.Message;


public class MainActivity extends AppCompatActivity {
    Spinner spinner;
    HttpURLConnection conexion;
    String nombreSeleccionado;
    CheckBox checkBox;
    String direccion = "1f2c09dc.ngrok.io";


    Handler manejador = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            Bundle bundle = msg.getData();
            String texto = bundle.getString("texto");

            Toast.makeText(getBaseContext(), texto, Toast.LENGTH_LONG).show();
        }
    };

    Handler manejador2 = new Handler() {
        @Override
        public void handleMessage(Message msg) {

            Bundle bundle = msg.getData();
            List<String> elementos = bundle.getStringArrayList("lista");

            ArrayAdapter<String> adaptador = new ArrayAdapter<String>(MainActivity.this, R.layout.support_simple_spinner_dropdown_item, elementos);

            adaptador.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

            spinner.setAdapter(adaptador);
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        checkBox = (CheckBox) findViewById(R.id.checkBox);

        spinner = (Spinner) findViewById(R.id.spinner);
        spinner.setOnItemSelectedListener(seleccionarItem);

        Thread hilo1 = new Thread(new Runnable() {
            @Override
            public void run() {

                //CHECAR LA CONEXION DE RED
                ConnectivityManager connectivityManager = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
                NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();
                if (networkInfo != null && networkInfo.isConnected()) {
                    try {
                        descargarUrl("http://" + direccion + "/Floreria/php/seleccionarBD.php");
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                } else {

                    Message mensaje = manejador.obtainMessage();
                    Bundle bundle = new Bundle();
                    bundle.putString("texto", "No tienes conexion");
                    mensaje.setData(bundle);
                    manejador.sendMessage(mensaje);

                }
            }
        });
        hilo1.start();
    }


    //CONECTAR Y DESCARGAR DATOS
    private void descargarUrl(String myUrl) throws IOException {
        InputStream is = null;

        try {
            URL url = new URL(myUrl);
            conexion = (HttpURLConnection) url.openConnection();
            conexion.setDoInput(true);

            conexion.connect();
            int respuesta = conexion.getResponseCode();
            Log.d("RESPUESTA: ", "La respuesta es: " + respuesta);
            is = conexion.getInputStream();

            llenarSpinner(is);

        } finally {
            if (is != null) {
                is.close();
            }
        }
    }


    private void llenarSpinner(InputStream is) throws IOException {
        BufferedReader buffer = new BufferedReader(new InputStreamReader(is));
        String letras = buffer.readLine();
        try {
            List<String> elementos = new ArrayList<>();
            JSONArray jsonArray = new JSONArray(letras);
            for (int i = 0; i < jsonArray.length(); i++) {
                elementos.add(jsonArray.getString(i));
            }

            Message mensaje = manejador2.obtainMessage();
            Bundle bundle = new Bundle();
            bundle.putStringArrayList("lista", (ArrayList<String>) elementos);
            mensaje.setData(bundle);
            manejador2.sendMessage(mensaje);

        } catch (JSONException e) {
//ERROR
        }

    }


    public void camara(View view) {
        Uri ruta;

        File directorio = new File(Environment.getExternalStorageDirectory().getPath() + "/FotosFlorFeliz/");
        directorio.mkdir();

        File imagen = new File(directorio, "foto.jpg");
        ruta = Uri.fromFile(imagen);

        Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        intent.putExtra(MediaStore.EXTRA_OUTPUT, ruta);
        startActivityForResult(intent, 100);
    }


    public void enviarDatos(View view) throws IOException {
        if (checkBox.isChecked()) {
            borrarImagenes();
            Message mensaje = manejador.obtainMessage();
            Bundle bundle = new Bundle();
            bundle.putString("texto", "Bien. Entregaste el pedido,");
            mensaje.setData(bundle);
            manejador.sendMessage(mensaje);
        } else {
            Thread hilo2 = new Thread(new Runnable() {
                @Override
                public void run() {
                    try {
                        URL url = new URL("http://" + direccion + "/Floreria/php/subirImagen.php");
                        HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                        conn.setDoOutput(true);
                        conn.connect();

                        Bitmap bitmap = BitmapFactory.decodeFile(Environment.getExternalStorageDirectory().getPath() + "/FotosFlorFeliz/foto.jpg");
                        ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
                        bitmap.compress(Bitmap.CompressFormat.JPEG, 25, byteArrayOutputStream);
                        byte[] bytes = byteArrayOutputStream.toByteArray();
                        String imagen = Base64.encodeToString(bytes, Base64.DEFAULT);

                        OutputStreamWriter escribir = new OutputStreamWriter(conn.getOutputStream());
                        //parametros = URLEncoder.encode("imagen", "UTF-8") + "=" + URLEncoder.encode(imagen, "UTF-8");
                        //parametros += URLEncoder.encode("nombre", "UTF-8") + "=" + URLEncoder.encode(nombreSeleccionado, "UTF-8");

                        String parametros = URLEncoder.encode("imagen", "UTF-8") + "=" + URLEncoder.encode(imagen, "UTF-8");
                        escribir.write(parametros);
                        escribir.flush();
                        escribir.close();

                        InputStream in = new BufferedInputStream(conn.getInputStream());
                        in.close();

                        Message mensaje = manejador.obtainMessage();
                        Bundle bundle = new Bundle();
                        bundle.putString("texto", "¡Foto exitosamente subida!");
                        mensaje.setData(bundle);
                        manejador.sendMessage(mensaje);

                        moverDatos();
                    } catch (Exception e) {
//ERROR
                    }
                }
            });
            hilo2.start();

            try {


            } catch (Exception e) {
//ERROR
            }
        }
    }


    public void moverDatos() throws IOException {
        Thread hilo3 = new Thread(new Runnable() {
            @Override
            public void run() {
                try {

                    URL url = new URL("http://" + direccion + "/Floreria/php/moverImagen.php");
                    HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                    conn.setDoOutput(true);
                    conn.connect();


                    OutputStreamWriter escribir = new OutputStreamWriter(conn.getOutputStream());

                    String parametros = URLEncoder.encode("nombre", "UTF-8") + "=" + URLEncoder.encode(nombreSeleccionado, "UTF-8");
                    escribir.write(parametros);
                    escribir.flush();
                    escribir.close();

                    InputStream in = new BufferedInputStream(conn.getInputStream());
                    in.close();


                } catch (Exception e) {
//ERROR
                }
            }
        });
        hilo3.start();
    }


    private void borrarImagenes() {
        Thread hilo4 = new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    URL url = new URL("http://" + direccion + "/Floreria/php/borrarImagenes.php");
                    HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                    conn.setDoOutput(true);
                    conn.connect();


                    OutputStreamWriter escribir = new OutputStreamWriter(conn.getOutputStream());

                    String parametros = URLEncoder.encode("nombre", "UTF-8") + "=" + URLEncoder.encode(nombreSeleccionado, "UTF-8");
                    escribir.write(parametros);
                    escribir.flush();
                    escribir.close();

                    InputStream in = new BufferedInputStream(conn.getInputStream());
                    in.close();


                } catch (Exception e) {
//ERROR
                }
            }
        });
        hilo4.start();
    }

    private AdapterView.OnItemSelectedListener seleccionarItem = new AdapterView.OnItemSelectedListener() {
        @Override
        public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
            nombreSeleccionado = parent.getItemAtPosition(position).toString();
        }

        @Override
        public void onNothingSelected(AdapterView<?> parent) {

        }
    };

}
