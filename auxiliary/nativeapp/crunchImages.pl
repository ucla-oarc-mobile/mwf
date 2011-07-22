#!/usr/bin/perl

#use strict;


# Full size splash screens -- 480x800 and 800x480 respectively
my %BG = ('port' => 'background_portrait.png', 'land' => 'background_landscape.png');

# Full size icon -- some multiple of 60x60 on a 72x72 transparent canvas (e.g. 300x300 on 360x360 canvas)
# See "Launcher Icons" under Android dev guide, best practices section
my $fs_icon = 'appicon_fullsize.png';

my %DENS = (
'hdpi' => '480x800',
'mdpi' => '320x480',
'ldpi' => '240x320'
);

my %ICONS = (
'hdpi' => '72',
'mdpi' => '48',
'ldpi' => '36'
);


my @ORIENT = qw(port land);

my @LONG = qw(long notlong);

my $convert = `which convert`;
chomp $convert;

foreach $density(keys %DENS) {
	foreach $orient(@ORIENT) {
		if ($density ne 'mdpi') {
			foreach $long(@LONG) {
				&crunch_image($density, $orient, $long);
			}
		} else {
			&crunch_image($density, $orient, 'notlong');
		}
	}
}



sub crunch_image {
	local ($d, $o, $l) = @_;
	print "$DENS{$d}\t$o\t$l\n";
	local $geometry = $DENS{$d};
	if ($o eq 'land') {
		local($x, $y) = split(/x/, $geometry, 2);
		$geometry = $y . 'x' . $x;
	}
	print $geometry . "\n";
	
	local $cmd = "$convert -geometry $geometry $BG{$o} Resources/android/images/res-$l-$o-$d/default.png";
	print $cmd . "\n";
	system($cmd);
	
	# At this point one can use convert, composite, and/or mogrify with appropriate options to overlay text, icons, etc.
	
	local $icon_geometry = $ICONS{$d};
	$icon_geometry = $icon_geometry . 'x' . $icon_geometry;
	$cmd = "$convert -geometry $icon_geometry $fs_icon Resources/android/images/res-$d/appicon.png";
	print $cmd . "\n";
	system($cmd);
	system("$convert -geometry 72x72 $fs_icon Resources/android/appicon.png");	
}
