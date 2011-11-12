//
//  UCLAMobileAppDelegate.h
//  UCLAMobile
//
//  Created by SVETA on 9/14/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>

#import "MWFWebView.h"

@interface UCLAMobileAppDelegate : NSObject <UIApplicationDelegate>

@property (nonatomic, retain) IBOutlet UIWindow *window;

@property (nonatomic, retain) IBOutlet MWFWebView *mwfWebView;

@end
