package edu.ucla.m;


import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.graphics.Bitmap;
import android.net.ConnectivityManager;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.View;
import android.view.Window;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class MWFWebViewActivity extends Activity {
	
	
	protected static final String OFFLINE_PAGE = "file:///android_asset/www/index.html";
	protected static final String ONLINE_PAGE  = "http://m.ucla.edu";
	
	protected WebView webView;
	
	private ProgressDialog spinnerDialog;

	
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
    
    	super.onCreate(savedInstanceState);
    	
    	//Removes the title from the container window.
    	requestWindowFeature(Window.FEATURE_NO_TITLE);
    	setContentView(R.layout.main);
	 
	    webView = (WebView) findViewById(R.id.webview);
	    webView.getSettings().setJavaScriptEnabled(true);
	    webView.setWebViewClient(new MWFWebViewClient());
	    webView.setScrollBarStyle(WebView.SCROLLBARS_OUTSIDE_OVERLAY);
	    
	    webView.loadUrl((isDeviceOnline()) ? ONLINE_PAGE : OFFLINE_PAGE);
    }
    
    @Override
    public void onResume()
    {
    	super.onResume();
    
    	
        
      
    }
    
    /**
     * Checks if the current device has access to Internet.
     * @return true if the current device has access to Internet.
     */
    public boolean isDeviceOnline() 
    {
    	ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
    	
    	return cm.getActiveNetworkInfo() != null && cm.getActiveNetworkInfo().isConnectedOrConnecting();

	}
    
    /**
     * Show the spinner.  Must be called from the UI thread.
     * 
     * @param title         Title of the dialog
     * @param message       The message of the dialog
     */
    public void spinnerStart(final String title, final String message) 
    {
    

    	//If the spinner is already started, just reset the title and the
    	//message fields.
    	if (this.spinnerDialog != null) 
    	{
            this.spinnerDialog.setTitle(title);
            this.spinnerDialog.setMessage(message);
    		
    		return;
        }
        
    	final MWFWebViewActivity me = this;
    	
        this.spinnerDialog = ProgressDialog.show(MWFWebViewActivity.this, 
        										 title ,
        										 message, 
        										 true, 
        										 true, 
        										 new DialogInterface.OnCancelListener() 
        										 { 
            											public void onCancel(DialogInterface dialog) 
            											{
            												me.spinnerDialog = null;
            											}
        										 });
    }

    /**
     * Stop spinner.
     */
    public void spinnerStop() {
        if (this.spinnerDialog != null) 
        {
        	
            this.spinnerDialog.dismiss();
            this.spinnerDialog = null;
        }
    }
    
    public void displayErrorMessage(String message)
    {
    	new AlertDialog.Builder(this)
        .setMessage(message)
        .setTitle("UCLA Mobile")
        .setCancelable(true)
        .setNeutralButton("OK", null)
        .show();
    }
    
    /**
     * Capture the back key and if available, go back to the previous page in 
     * the web view's history. 
     */
    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        
    	if ((keyCode == KeyEvent.KEYCODE_BACK) && webView.canGoBack()) 
    	{
            webView.goBack();
            return true;
        }
    	
        return super.onKeyDown(keyCode, event);
    }
    
    
    private class MWFWebViewClient extends WebViewClient {
    	
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            
        	view.getSettings().setCacheMode((isDeviceOnline())? WebSettings.LOAD_DEFAULT : WebSettings.LOAD_CACHE_ONLY);
        	
        	view.loadUrl(url);
        	
            return true;
        }
        
        public void onPageStarted(WebView view, String url, Bitmap favicon) {
            if(isDeviceOnline())
            	spinnerStart("", "Loading UCLA Mobile...");
        }
        
        public void onPageFinished(WebView view, String url) {
            spinnerStop();
        }
        
        @Override
        public void onReceivedError(WebView view, int errorCode, String description, String failingUrl)
        {
        	displayErrorMessage("Error loading page - are you offline?");
        	
        	view.stopLoading();
        	view.clearView();
        	
        	if(view.canGoBack())
        		view.goBack();
        	
        	
        }
    
    }
}