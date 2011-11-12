//
//  UCLAMobileAppDelegate.m
//  UCLAMobile
//
//  Created by SVETA on 9/14/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import "UCLAMobileAppDelegate.h"
#import "MWFWebView.h"

@implementation UCLAMobileAppDelegate

@synthesize window = _window;

@synthesize mwfWebView = _mwfWebVew;


- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    
    
    //Create a new web view controller.
    MWFWebView *mwfWebView = [[MWFWebView alloc] initWithNibName:@"MWFWebView" bundle:nil];
    
    //Assign it to the webView property within the window.
    self.mwfWebView = mwfWebView;
    
    //Release the local version.
    [mwfWebView release];
    
    
    //Set the web view's parent window. This will be used to add the web view
    //to the window as soon as the initial page has loaded. The process avoids
    //displaying a blank screen until the page is loaded.
    [self.mwfWebView setParentWindow:self.window];
    
    
    //Set the main view of the widow to the web view.
    self.window.rootViewController = self.mwfWebView;
    
    // Override point for customization after application launch.
    [self.window makeKeyAndVisible];
    
    return YES;
}

- (void)applicationWillResignActive:(UIApplication *)application
{
    /*
     Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
     Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
     */
}

- (void)applicationDidEnterBackground:(UIApplication *)application
{
    /*
     Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later. 
     If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
     */
}

- (void)applicationWillEnterForeground:(UIApplication *)application
{
    /*
     Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
     */
}

- (void)applicationDidBecomeActive:(UIApplication *)application
{
    /*
     Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
     */
}

- (void)applicationWillTerminate:(UIApplication *)application
{
    /*
     Called when the application is about to terminate.
     Save data if appropriate.
     See also applicationDidEnterBackground:.
     */
}

- (void)dealloc
{
    [_window release];
    [_mwfWebVew release];
    [super dealloc];
}

@end
