package com.hao.cabapp;

import com.hao.cabapp.utils.CabAppConstants;
import com.hao.cabapp.utils.CentralUtils;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;

public class FrontController extends Activity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_front_controller);
		CentralUtils cu=CentralUtils.getInstance();
		if(cu.getGeoObject().getState().equals(CabAppConstants.MESSAGE_NOT_COPIED_STATUS)){
			Intent i=new Intent(this, NotifySMS.class);
			i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP
					| Intent.FLAG_ACTIVITY_SINGLE_TOP);
			startActivity(i);
		}else{
			Intent i=new Intent(this, UserActivity.class);
			i.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP
					| Intent.FLAG_ACTIVITY_SINGLE_TOP);
			startActivity(i);
		}
		this.finish();
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.front_controller, menu);
		return true;
	}

}
