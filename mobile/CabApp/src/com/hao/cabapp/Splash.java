package com.hao.cabapp;

import com.hao.cabapp.utils.CentralUtils;

import android.os.Bundle;
import android.widget.Toast;
import android.app.Activity;
import android.content.ComponentName;
import android.content.Intent;
import android.content.pm.PackageManager;

public class Splash extends Activity {
	@Override
	protected void onCreate(Bundle splashBundle) {
		super.onCreate(splashBundle);
		setContentView(R.layout.activity_splash);
		Thread timer = new Thread() {
			public void run() {
				try {
					sleep(2000);
				} catch (InterruptedException e) {
					e.printStackTrace();
				} finally {
					CentralUtils.setContext(getApplicationContext());
					CentralUtils cu=CentralUtils.getInstance();
					cu.getLocation(getApplicationContext());
					//Log.d("aawa","aawa do"+cu.getLoggedin().trim() );
					
					//Toast.makeText(getApplicationContext(), cu.getLoggedin().trim(),Toast.LENGTH_LONG).show();
					if(!cu.getLoggedin().trim().equals("login")){
					Intent openMainActivity = new Intent(Splash.this,
							MainActivity.class);
					/*Intent i2 = new Intent(getApplicationContext(),
							DataPushService.class);
					startService(i2);
					ComponentName component = new ComponentName(
							getApplicationContext(), IncomingSms.class);
					getPackageManager().setComponentEnabledSetting(
							component,
							PackageManager.COMPONENT_ENABLED_STATE_ENABLED,
							PackageManager.DONT_KILL_APP);*/
					startActivity(openMainActivity);
					}else{
						Intent openUserActivity = new Intent(Splash.this,
								UserActivity.class);
						startActivity(openUserActivity);
					}
				}
			}
		};
		timer.start();
	}

	@Override
	protected void onPause() {
		super.onPause();
		finish();
	}
}