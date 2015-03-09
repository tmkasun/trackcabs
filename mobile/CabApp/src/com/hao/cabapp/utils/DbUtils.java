package com.hao.cabapp.utils;

import java.util.ArrayList;
import java.util.HashMap;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

public class DbUtils extends SQLiteOpenHelper {
	private static final int DbVersion = 2;
	private static final String DbName = "Cache_Database";
	private static final String TableName = "cachetable";
	private static final String colid = "id";
	private static final String colvalue = "data";
	private static final String colorderid = "orderid";
	private static final String colorderhash = "orderhash";
	
	private static final String orderTableName = "orderTable";
	
	public DbUtils(Context context) {
		super(context, DbName, null, DbVersion);
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
		String sqlQuerry = "CREATE TABLE " + TableName + "(" + colid
				+ " INTEGER PRIMARY KEY," + colvalue
				+ " TEXT," + colorderid
				+ " TEXT," + colorderhash
				+ " TEXT)";
		String sqlOrderQuerry = "CREATE TABLE " + orderTableName + "(" + colorderid
				+ " INTEGER PRIMARY KEY,"+ colorderhash
				+ " TEXT)";
		db.execSQL(sqlQuerry);
		db.execSQL(sqlOrderQuerry);
		init(db);
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		db.execSQL("DROP TABLE IF EXISTS " + TableName);
		db.execSQL("DROP TABLE IF EXISTS " + orderTableName);
		onCreate(db);
	}

	public void addData(String data,String orderid,String orderhash) {
		int id=1;
		SQLiteDatabase db = this.getWritableDatabase();
		ContentValues cv = new ContentValues();
		cv.put(colvalue, data);
		cv.put(colorderid, orderid);
		cv.put(colorderhash, orderhash);
		db.update(TableName, cv, "id=" + id, null);
		db.close();
	}
	
	/////////////////////////////////////////////////////////Order Functions////////////////////////////////////
	
	public void addOrder(String orderid,String orderhash) {
		//int id=getLastOrderId();
		//id++;
		SQLiteDatabase db = this.getWritableDatabase();
		ContentValues cv = new ContentValues();
		cv.put(colorderid, orderid);
		cv.put(colorderhash, orderhash);
		db.insert(orderTableName,null, cv);
		db.close();
	}
	
	public ArrayList<String> getPendingOrdersAsList(){
		SQLiteDatabase db = this.getReadableDatabase();
		ArrayList<String> orderHashes = new ArrayList<String>();
		Cursor cursor = db.query(orderTableName, new String[] {colorderid,colorderhash}, colorderid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);
		if (cursor != null){ 
			while(cursor.moveToNext()){
				orderHashes.add(cursor.getString(1));
				deleteOrder(cursor.getString(0));   ///check again
			}
			
		}
		cursor.close();
		db.close();
		return orderHashes;
	}
	
	public void deleteOrder(String orderId){
		SQLiteDatabase db = this.getReadableDatabase();
		db.execSQL("DELETE from "+orderTableName +" WHERE "+colorderid+" = '"+Integer.parseInt( orderId)+"'");
			
	}
	 
	public void emptyOrderTable(){
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.query(orderTableName, new String[] {colorderid,colorderhash}, colorderid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);
		if (cursor != null){
			while(cursor.moveToNext()){
				deleteOrder(cursor.getString(0));   ///check again
			}
			
		}
		cursor.close();
		db.close();
	}
	public HashMap<String,String> getNextOrder(){
		SQLiteDatabase db = this.getReadableDatabase();
		/*Cursor cursor = db.query(orderTableName, new String[] {colorderid,colorderhash}, colorderid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);*/
		Cursor cursor = db.rawQuery("SELECT "+colorderid+","+colorderhash+" FROM "+orderTableName, null);
		
		HashMap<String,String> hm=new HashMap<String,String>();
		
		if (cursor != null){
			if(cursor.moveToFirst()){
			hm.put("orderId", cursor.getString(0));
			hm.put("orderHash", cursor.getString(1));
			deleteOrder(cursor.getString(0));
			hm.put("test", "deleted "+cursor.getString(0));
			}else{
				hm.remove("test");
				hm.put("test", "false");
			}
		}else{
			hm.remove("test");
			hm.put("test", "cursor null");
		}
		cursor.close();
		db.close();
		return hm;
	}
	
	public ArrayList<String> getPendingOrderIds(){
		ArrayList<String> ar=new ArrayList<String>();
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.rawQuery("SELECT "+colorderid+" FROM "+orderTableName, null);
		if (cursor != null){ 
			while(cursor.moveToNext()){
				ar.add(cursor.getString(0));
			}
		}
		return ar;
	}
	
	public int getLastOrderId() {
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.query(orderTableName, new String[] {colorderid,colorderhash}, colorderid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);
		if (cursor != null)
			cursor.moveToLast();
		int result=cursor.getInt(0);
		cursor.close();
		db.close();
		return result;
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////

	public void init(SQLiteDatabase db) {
		ContentValues cv = new ContentValues();
		cv.put(colid, 1);
		cv.put(colvalue, "idle");
		cv.put(colorderid, "");
		cv.put(colorderhash, "");
		db.insert(TableName, null, cv);
		
	}

	public String getState() {
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.query(TableName, new String[] { colid,
				colvalue,colorderid }, colid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);
		if (cursor != null)
			cursor.moveToFirst();
		String result=cursor.getString(1);
		cursor.close();
		db.close();
		return result;
	}
	
	public String getOrderid() {
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.query(TableName, new String[] { colid,
				colvalue,colorderid }, colid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);
		if (cursor != null)
			cursor.moveToFirst();
		String result=cursor.getString(2);
		cursor.close();
		db.close();
		return result;
	}
	
	public String getOrderhash() {
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.query(TableName, new String[] { colid,
				colvalue,colorderid,colorderhash }, colid + "=?", new String[] { String.valueOf(1) },
				null, null, null, null);
		if (cursor != null)
			cursor.moveToFirst();
		String result=cursor.getString(3);
		cursor.close();
		db.close();
		return result;
	}

	public String getData() {
		SQLiteDatabase db = this.getReadableDatabase();
		Cursor cursor = db.rawQuery("SELECT * FROM cachetable WHERE id=1" ,
				null);
		if (cursor != null)
			cursor.moveToFirst();
		return cursor.getString(1);
	}
}
