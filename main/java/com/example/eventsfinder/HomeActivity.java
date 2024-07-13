package com.example.eventsfinder;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.viewpager2.widget.ViewPager2;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.auth.api.signin.GoogleSignIn;
import com.google.android.gms.auth.api.signin.GoogleSignInAccount;
import com.google.android.material.bottomnavigation.BottomNavigationView;

import java.util.Arrays;
import java.util.List;

public class HomeActivity extends AppCompatActivity {

    private TextView welcomeTextView;
    private Button viewMapButton;
    private ViewPager2 viewPager;
    private Toolbar myToolbar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        // Initialize Toolbar
        myToolbar = findViewById(R.id.toolbar);
        setSupportActionBar(myToolbar);

        welcomeTextView = findViewById(R.id.welcome_text);
        viewMapButton = findViewById(R.id.view_map_button);
        viewPager = findViewById(R.id.viewPager);

        GoogleSignInAccount account = GoogleSignIn.getLastSignedInAccount(this);
        if (account != null) {
            String welcomeMessage = "Welcome, " + account.getDisplayName() + "!";
            welcomeTextView.setText(welcomeMessage);
        }

        viewMapButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(HomeActivity.this, MapsActivity.class);
                startActivity(intent);
            }
        });

        BottomNavigationView bottomNavigationView = findViewById(R.id.bottomNavigationView);
        bottomNavigationView.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                int itemId = item.getItemId();
                if (itemId == R.id.home) {
                    return true;
                } else if (itemId == R.id.maps) {
                    startActivity(new Intent(HomeActivity.this, MapsActivity.class));
                    return true;
                } else if (itemId == R.id.events) {
                    startActivity(new Intent(HomeActivity.this, EventsActivity.class));
                    return true;
                } else if (itemId == R.id.profile) {
                    startActivity(new Intent(HomeActivity.this, AboutActivity.class));
                    return true;
                }
                return false;
            }
        });

        // Set up ViewPager2
        List<Integer> imageList = Arrays.asList(
                R.drawable.images, // Replace with actual image names
                R.drawable.usr_1645517025328, // Replace with actual image names
                R.drawable.sport, // Replace with actual image names
                R.drawable.fest, // Replace with actual image names
                R.drawable.flash  // Replace with actual image names
        );

        ImageSliderAdapter adapter = new ImageSliderAdapter(this, imageList);
        viewPager.setAdapter(adapter);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_toolbar, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int itemId = item.getItemId();
        if (itemId == R.id.action_logout) {
            logout();
            return true;
        } else {
            return super.onOptionsItemSelected(item);
        }
    }

    private void logout() {
        Toast.makeText(this, "Logged out", Toast.LENGTH_SHORT).show();
        Intent intent = new Intent(this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }
}
