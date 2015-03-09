package com.hao.cabapp;

import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.ProgressDialog;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;
import android.support.v4.app.NotificationCompat.Builder;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.hao.cabapp.utils.CabAppConstants;
import com.hao.cabapp.utils.CentralUtils;
import com.hao.cabapp.utils.DataManipulationUtils;
import com.hao.cabapp.utils.DbUtils;
import com.hao.cabapp.utils.JSONParser;

public class MainActivity extends Activity {
	Intent i2;
	private ProgressDialog progressDialog;
	TextView loginID;
	TextView password;
	Context thisCon;
	Activity loopback;
	DbUtils dbUtils;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		// CentralUtils.getInstance();
		// CentralUtils.setContext(getApplicationContext());
		dbUtils = new DbUtils(getApplicationContext());
		setContentView(R.layout.activity_main);
		Button startBtn = (Button) findViewById(R.id.btnStart);
		DbUtils db = new DbUtils(getApplicationContext());
		// db.addData(CabAppConstants.IDLE_STATUS, "45", "#45171");
		loginID = (TextView) findViewById(R.id.txtLoginID);
		password = (TextView) findViewById(R.id.txtPassword);

		thisCon = this;
		loopback = this;
		startBtn.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View arg0) {
				if (!CentralUtils.getInstance().getLoggedin().equals("login")) {
					if (loginID.getText().toString().trim().equals("")
							|| password.getText().toString().trim().equals("")) {
						AlertDialog.Builder builder = new AlertDialog.Builder(
								thisCon);
						builder.setTitle("Fill the Fields !")
								.setCancelable(true)
								.setMessage("Please do the $subject")
								.setPositiveButton("OK",
										new DialogInterface.OnClickListener() {
											public void onClick(
													DialogInterface dialog,
													int id) {

											}
										});
						AlertDialog alert = builder.create();
						alert.show();
					} else {
						new Read().execute();
						/*
						 * SmsManager sms = SmsManager.getDefault();
						 * CentralUtils cu = CentralUtils.getInstance();
						 */
						// cu.setIp(ip.getText().toString());
						/*
						 * sms.sendTextMessage(cu.getDispatcherNo(), null,
						 * "LoginID:" + loginID.getText().toString() +
						 * ",Password:" + password.getText().toString(), null,
						 * null);
						 */
					}
				}
			}
		});

		Button stopbtn = (Button) findViewById(R.id.btnStop);
		stopbtn.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				// stopService(i2);

				new End().execute();
			}
		});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.main, menu);

		return true;
	}

	public class Read extends AsyncTask<String, Integer, String> {
		String res;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressDialog = new ProgressDialog(MainActivity.this);
			progressDialog.setCancelable(true);
			progressDialog.setMessage("Log in ...");
			progressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			progressDialog.setProgress(0);
			progressDialog.show();
		}

		@Override
		protected void onPostExecute(String result) {
			try {
				/*
				 * JSONObject jp=new JSONObject(result); CentralUtils
				 * cu=CentralUtils.getInstance();
				 * cu.getGeoObject().setHash(jp.getString("Hash"));
				 */
				// Put in some JSON Retrieve logic
				// Toast.makeText(getApplicationContext(), result,
				// Toast.LENGTH_LONG);

				/*
				 * Toast.makeText(getApplicationContext(), result,
				 * Toast.LENGTH_LONG);
				 */
				/* loginID.setText(result); */
				if (result.toLowerCase().contains("ioerror")) {
					progressDialog.dismiss();
					AlertDialog.Builder builder = new AlertDialog.Builder(
							thisCon);
					builder.setTitle("Network Error !")
							.setCancelable(true)
							.setMessage(
									"Your Internet Connection is not working. Please switch the data connection on...!")
							.setPositiveButton("OK",
									new DialogInterface.OnClickListener() {
										public void onClick(
												DialogInterface dialog, int id) {
											loginID.setText("");
											password.setText("");
										}
									});
					AlertDialog alert = builder.create();
					alert.show();
				} else {

					JSONObject ob = new JSONObject(result);
					String isAuthorized = ob.getString("isAuthorized");
					if (isAuthorized.trim().equals("true")) {
						CentralUtils cu = CentralUtils.getInstance();
						cu.setLoggedin("login");
						cu.getGeoObject().setDriverID(ob.getString("driverId"));
						cu.getGeoObject().setCabID(ob.getString("cabId"));
						cu.getGeoObject().setVehicleType(
								ob.getString("vehicleType"));
						if (!cu.getGeoObject().getCabID().trim().equals("-1")) {
							if (cu.getTimerTask() == null) {
								cu.getGeoObject().setState(dbUtils.getState());
								i2 = new Intent(getApplicationContext(),
										DataPushService.class);
								startService(i2);
								
								/*  This is critical if (!cu.getGeoObject().getState()
										.equals(CabAppConstants.IDLE_STATUS)
										&& !cu.getGeoObject()
												.getState()
												.equals(CabAppConstants.MESSAGE_NOT_COPIED_STATUS)) {*/
									Intent i = new Intent(
											getApplicationContext(),
											UserActivity.class);
									progressDialog.dismiss();
									loopback.finish();
									startActivity(i);
								/*}else{
									Toast.makeText(getApplicationContext(), "Go on"+cu.getGeoObject()
											.getState(), Toast.LENGTH_LONG).show();
								}*/
								
								ComponentName component = new ComponentName(
										getApplicationContext(),
										IncomingSms.class);
								getPackageManager()
										.setComponentEnabledSetting(
												component,
												PackageManager.COMPONENT_ENABLED_STATE_ENABLED,
												PackageManager.DONT_KILL_APP);
							}
						}else{
							AlertDialog.Builder builder = new AlertDialog.Builder(
									MainActivity.this);
							builder.setTitle("No cab ID assigned")
									.setCancelable(true)
									.setMessage("Cab ID is not assigned.Please contact the admin")
									.setPositiveButton("OK",
											new DialogInterface.OnClickListener() {
												public void onClick(DialogInterface dialog,
														int id) {
													loginID.setText("");
													password.setText("");
												}
											});
							AlertDialog alert = builder.create();
							alert.show();
						}
						if (dbUtils.getState().equals(
								CabAppConstants.MESSAGE_NOT_COPIED_STATUS)) {
							String message = cu
									.getLastSMS(getContentResolver());
							if (message != null) {
								Intent kl = new Intent(thisCon, NotifySMS.class);
								kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
								kl.putExtra("message", message);
								kl.putExtra("senderNum", cu.getDispatcherNo());
								progressDialog.dismiss();
								loopback.finish();
								thisCon.startActivity(kl);
							}
						} else if (dbUtils.getState().equals(
								CabAppConstants.IDLE_STATUS)
								&& !dbUtils.getOrderid().equals("")) {
							DataManipulationUtils dm = new DataManipulationUtils();
							String message = cu
									.getLastSMS(getContentResolver());
							String[] ar = dm.readDetailsFromSMS(message);
							// dbUtils.addData("pending", "");
							if (!ar[1].equals(dbUtils.getOrderid())) {
								Intent kl = new Intent(thisCon, NotifySMS.class);
								cu.getGeoObject()
										.setState(
												CabAppConstants.MESSAGE_NOT_COPIED_STATUS);
								kl.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
								kl.putExtra("message", message);
								kl.putExtra("senderNum", cu.getDispatcherNo());
								progressDialog.dismiss();
								loopback.finish();
								thisCon.startActivity(kl);

							}
						}

					} else {
						progressDialog.dismiss();
						AlertDialog.Builder builder = new AlertDialog.Builder(
								thisCon);
						builder.setTitle("Wrong Credentials !")
								.setCancelable(true)
								.setMessage(
										"Your entered wrong credentials.Please check your user id and password ")
								.setPositiveButton("OK",
										new DialogInterface.OnClickListener() {
											public void onClick(
													DialogInterface dialog,
													int id) {
												loginID.setText("");
												password.setText("");
											}
										});
						AlertDialog alert = builder.create();
						alert.show();
					}
				}
			} catch (Exception e) {
				e.printStackTrace();
			}

		}

		@Override
		protected String doInBackground(String... params) {
			try {
				JSONParser jp = new JSONParser();
				JSONObject jo = new JSONObject();
				long timeStamp = System.currentTimeMillis() / 1000L;
				jo.put("uName", loginID.getText().toString());
				jo.put("pass", password.getText().toString());
				jo.put("timeStamp", timeStamp);
				CentralUtils cu = new CentralUtils();

				// res=jp.sendJSONToUrl("http://50.18.212.27:3001",
				// jo.toString());
				// res=jp.sendJSONToUrl("http://"+cu.getIp()+"/index.php/driver_retriever/authenticate",
				// jo.toString());
				res = jp.sendJSONToUrl(CabAppConstants.LOGIN_URL, jo.toString());
			} catch (Exception e) {
				e.printStackTrace();
			}
			return res;
		}

	}

	public class End extends AsyncTask<String, Integer, String> {
		String res;

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressDialog = new ProgressDialog(MainActivity.this);
			progressDialog.setCancelable(true);
			progressDialog.setMessage("Log Out ...");
			progressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			progressDialog.setProgress(0);
			progressDialog.show();
		}

		@Override
		protected void onPostExecute(String result) {
			// Toast.makeText(getApplicationContext(), res,
			// Toast.LENGTH_LONG).show();
			JSONObject ob;
			// loginID.setText(result);
			try {
				ob = new JSONObject(result);
				String isAuthorized = "false";
				if (ob.has("isAuthorized"))
					isAuthorized = ob.getString("isAuthorized");
				if (!isAuthorized.trim().equals("true")) {
					AlertDialog.Builder builder = new AlertDialog.Builder(
							thisCon);
					builder.setTitle("Cant Logout")
							.setCancelable(true)
							.setMessage(
									"You are not allowed to logout.Please contact the authorized personnel ")
							.setPositiveButton("OK",
									new DialogInterface.OnClickListener() {
										public void onClick(
												DialogInterface dialog, int id) {
											// loginID.setText("");
											password.setText("");
										}
									});
					AlertDialog alert = builder.create();
					alert.show();
				} else {
					CentralUtils cu = CentralUtils.getInstance();
					if (cu.getTimerTask() != null) {
						cu.getTimerTask().cancel();
						cu.setTimerTask(null);
					}
					ComponentName component = new ComponentName(
							getApplicationContext(), IncomingSms.class);
					getPackageManager().setComponentEnabledSetting(component,
							PackageManager.COMPONENT_ENABLED_STATE_DISABLED,
							PackageManager.DONT_KILL_APP);
					cu.setLoggedin("logout");
					cu.remove();
					System.exit(1);
				}
			} catch (JSONException e) {
				//
			}

			progressDialog.dismiss();
		}

		@Override
		protected String doInBackground(String... params) {
			String h = "";
			try {
				JSONParser jp = new JSONParser();
				JSONObject jo = new JSONObject();
				long timeStamp = System.currentTimeMillis() / 1000L;
				jo.put("uName", CentralUtils.getInstance().getGeoObject()
						.getDriverID());
				jo.put("timeStamp", timeStamp);
				/*
				 * jo.put("pass", password.getText().toString());
				 * jo.put("login", "logout");
				 */
				h = jo.toString();
				res = jp.sendJSONToUrl(CabAppConstants.LOGOUT_URL,
						jo.toString());

			} catch (Exception e) {
				e.printStackTrace();
			}
			return res;
		}

	}

}