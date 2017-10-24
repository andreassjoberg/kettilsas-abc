=== Appointment Booking Calendar ===
Contributors: codepeople
Donate link: https://abc.dwbooster.com/download
Tags: appointment,booking,calendar,appointment calendar,booking calendar,booking form,paypal calendar,plugin,paypal bookings,paypal appointments,bookings,meeting,meet,scheduler,scheduler calendar,availability,availability calendar,agenda,reservation form,reservation calendar
Requires at least: 3.0.5
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Appointment Booking Calendar is an appointment calendar for accepting online bookings from a set of available time-slots in a calendar.

== Description ==

Appointment Booking Calendar is an appointment calendar plugin for **accepting online bookings** from a set of **available time-slots in a calendar**. The booking form is linked to a **PayPal** payment process.

You can use it to accept bookings for medical consultation, classrooms, events, transportation and other activities where a specific time from a defined set must be selected, allowing you to define the maximum number of bookings that can be accepted for each time-slot.

Features:

* The customer can **book an available time slot** from a defined set.
* The booking form is connected to a **PayPal** payment page
* You can define the **appointment booking capacity** for each time-slot. 
* A **notification** email is sent to the specified email addresses (one or more) after completed the booking payment.
* A **confirmation** email with the appointment data is sent to the user after completing the booking payment.
* You can **assign a user** to the appointment booking calendar. Users with "Editor Access Level" will get access to the appointment calendar only if it has been assigned previously.
* Exports the appointments to **iCal** format (Google Calendar, Outlook).
* Includes **captcha** validation for preventing spam from the appointment calendar form.
* The appointment calendar has a **printable list** of bookings.
* You can edit the text of the notification/confirmation emails.
* Allows defining the product name at PayPal, the currency, the PayPal language and amount to pay for an appointment booking (you can set zero to let the user pay/donate the desired amount).
* Allows defining the working days, the exact time slots available and the appointment capacity of each time slot.
* **Multi-page calendar:** You can setup it to show many months at once.
* **Multiple time-slot selection:** The custom can book many time-slots at once if allowed in the settings.
* Configurable date format: mm/dd/yyyy or dd/mm/yyyy
* Supports both am/pm and military time.
* Export appointment data to CSV / Excel files.
* You can define the **start day** of the week on the appointment calendar.
* You can define the **minimum** available date and the **maximum** available date for the bookings.
* You can block specific dates.
* Pretty modern administration interface.

Please note that this is a plugin originally designed to accept appointment bookings linked to PayPal payments. The feature for accepting appointments without PayPal is implemented/available in the commercial versions: https://abc.dwbooster.com/download

= Available Languages and Adding New Languages / Translations = 

The current translations are already available in the appointment calendar plugin:

* Afrikaans (af)
* Albanian (sq)
* Arabic (ar)
* Armenian (hy_AM)
* Azerbaijani (az)
* Basque (eu)
* Belarusian (be_BY)
* Bulgarian (bg_BG)
* Catalan (ca)
* Central Kurdish (ckb)
* Chinese (China zh_CN)
* Chinese (Taiwan zh_TW)
* Croatian (hr)
* Czech (cs_CZ)
* Danish (da_DK)
* Dutch (nl_NL)
* Esperanto (eo_EO) 
* Estonian (et)
* Finnish (fi)
* French (fr_FR)
* Galician (gl_ES)
* Georgian (ka_GE)
* German (de_DE)
* Greek (el)
* Gujarati (gu_IN)
* Hebrew (he_IL)
* Hindi (hi_IN)
* Hungarian (hu_HU)
* Indian Bengali (bn_IN)
* Indonesian (id_ID)
* Irish (ga_IE)
* Italian (it_IT)
* Japanese (ja)
* Korean (ko_KR)
* Latvian (lv)
* Lithuanian (lt_LT)
* Macedonian (mk_MK)
* Malay (ms_MY)
* Malayalam (ml_IN)
* Maltese (mt_MT)
* Norwegian (nb_NO)
* Persian (fa_IR)
* Polish (pl_PL)
* Portuguese Brazil(pt_BR)
* Portuguese (pt_PT)
* Punjabi (pa_IN)
* Russian (ru_RU)
* Romanian (ro_RO)
* Serbian (sr_RS)
* Slovak (sk_SK)
* Slovene (sl_SI)
* Spanish (es_ES)
* Swedish (sv_SE)
* Tagalog (tl) 
* Tamil (ta)
* Thai (th)
* Turkish (tr_TR)
* Ukrainian (uk)
* Vietnamese (vi)

If you want to add a new translation you can add a new PO/MO file into the "languages" folder. If you want to provide the translation for a new language you can send us the texts and we will create the PO/MO files for you. We will appreciate if you allow sharing your translation with other WordPress users.

= Updates =

New features has been published in the current Appointment Booking Calendar version 1.1.8 based on the feedback received and we would like to thank you all the people that have supported the development, provided feedback and feature requests. The plugin is currently over 140,000 downloads/installations (6000+ active installs) and a new set of updates is already being prepared, any feature requests will be welcome. Thank you!

== Installation ==

To install **Appointment Booking Calendar**, follow these steps:

1.	Download and unzip the Appointment Booking Calendar plugin
2.	Upload the entire appointment-booking-calendar/ directory to the /wp-content/plugins/ directory
3.	Activate the Appointment Booking Calendar plugin through the Plugins menu in WordPress
4.	Configure the settings at the administration menu >> Settings >> Appointment Booking Calendar. 
5.	To insert the appointment calendar form into some content or post use the icon that will appear when editing contents

== Frequently Asked Questions ==

= Q: What means each field in the appointment calendar settings area? =

A: The product's page contains detailed information about each appointment calendar field and customization:

https://abc.dwbooster.com


= Q: How can I center the appointment calendar into the page? =

A: For centering the calendar open the CSS file "TDE_AppCalendar\all-css.css" in any text editor and add these CSS rules into that file:

    .appContainer{text-align:center;}
    .appContainer2{margin-left:auto;margin-right:auto;width:200px}

After that be sure to refresh the page that contains the appointment scheduler form or clear your browser cache to be sure that the browser is loading the updated CCS styles file.


= Q: How can I cancel/delete an appointment to make its time slot available again? =

A: To delete an appointment locate it into the appointment calendar in the settings area, clear the title (there is a button for that) and save it. This action will delete the appointment (even if the content wasn't cleared).


= Q: How can I change the calendar's width and height? =

A: You can specify the size of the appointment calendar's cells, that way the complete appointment calendar width and height can be controlled.

Open the file "appointment-booking-calendar\TDE_AppCalendar\all-css.css" and about line #139 modify the "padding" applied to the cells:

    .yui-calendar td.calcell {
        padding:.3em .4em;
        border:1px solid #E0E0E0;
        text-align:center;
        vertical-align: top;
    }

= Q: Can I put an "acknowledgment / thank you message" after submitting an appointment and completing the PayPal payment? =

A: The "acknowledgment / thank you message" shown to the user after submitting the appointment form should be placed at the page indicated in the field "URL to return after successful payment". Note that after the submission the user is redirected first to PayPal and then to the "thank you" page once the payment for the booking has been completed.


= Q: How do I change the background color of the selected date on the appointment calendar? =

A: Open the file "wp-content/plugins/appointment-booking-calendar/TDE_AppCalendar/all-css.css" ... find this CSS rule:

    .yui-calendar td.calcell.reserveddate { background-color:#B6EA59; }

...and replace the background color that appears there.


= Q: How can I export the calendar iCal link with Google Calendar on a regular basis? =

A: Please read the instructions on this Google page:

https://support.google.com/calendar/answer/37100?hl=en

To get the iCal feed URL right click the "iCal" link on the calendar list and click "Copy Link Address" or "Copy Link Location" (depending of the browser you are using).

Note: This will automatically export the bookings stored in the calendar plugin to the Google Calendar. The inverse process (import the items on Google Calendar into the plugin) isn't currently available.


= Q: After booking appointment I'm not receiving the emails with the appointment data. =

A: Please check if after the completing the payment at PayPal the appointment appears registered in the appointment calendar (some time slot unavailable):

* **If the appointment purchase is registered**, then the problem is that you server has some additional configuration requirements to send emails from PHP. The Appointment Booking Calendar plugin uses the settings specified into the WordPress website to deliver the emails, if your hosting has some specific requirements like a fixed "from" address or a custom "SMTP" server those settings must be configured into the WordPress website.

* **If the appointment purchase isn't registered**, first check if you are testing the appointment booking form on a local website or in an online website. Note you should test this feature into an online website (local websites cannot receive PayPal IPN connections).

* **If the appointment purchase isn't registered and you are testing it on an online website**, then check if the payment appears as "completed" at the PayPal seller account (no red flags, no pending mark). Check also if your PayPal account is setup to automatically accept payments in the selected currency. The payment must be "accepted" and "completed" in the PayPal seller account.

= Q: How to make the appointment calendar 100% width? =

A: Add this CSS rule at the end of the file "wp-content/plugins/appointment-booking-calendar/css/stylepublic.css":

        .yui-calcontainer{width:98%}        


== Other Notes ==

= The Troubleshoot Area =

Use the troubleshot if you are having problems with special or non-latin characters. In most cases changing the charset to UTF-8 through the option available for that in the troubleshot area will solve the problem.

You can also use this area to change the script load method if the booking calendar isn't appearing in the public website.

There are also two fields related to the iCal settings: the "iCal time zone difference vs. server time" and the "iCal timeslot size in minutes". The "iCal time zone difference vs. server time" can be updated to match the desired time zone. The difference is calculated referred to the server time, you may have to test some values until finding the one that matches the desired time-zone.  The "iCal timeslot size in minutes" can be modified to have a specific slot time in the exported iCal file.


= The Restricted Dates Tab =

The "Restricted Dates" tab into the calendar settings lets you to completely disable selected dates from the appointment calendar. This is useful for excluding public holidays or other specific dates where no appointments will be offered.

To restrict a date just click it into the date picker calendar that appears in this tab. To remove an already restricted date, just click it again.

= The Special Dates Tab =

The "Restricted Dates" tab into the calendar settings lets you use a different time-slots schedule for specific dates. For example you can have the same time-slots available for all Tuesdays in the appointment booking calendar, but if you want to offer different time-slots on a specific Tuesday then you can use the "Special Dates" tab to overwrite the time-slots for that date.

To use this section click a date into the date picker that appears on the "Restricted Dates" tab and a floating panel will appear for editing the available time-slots for the selected date.
 
= The Notification Emails =

The notification emails with the appointment data entered in the booking form can sent in "Plain Text" format (default) or in "HTML" format. If you select "HTML" format, be sure to use the BR or P tags for the line breaks into the text and to use the proper formatting.

 
= Displaying a List of Appointments = 

A list with the appointments set on the calendar can be displayed by using this shortcode in the page where you want to display the list:

    [CPABC_APPOINTMENT_LIST]

... can be also customized with some parameters if needed, example:

    [CPABC_APPOINTMENT_LIST from="today" to="today +30 days" fields="DATE,TIME,NAME" calendar="1"]

... the "from" and "to" are used to display only the appointments / bookings on the specified period. That can be either indicated as relative days to "today" or as fixed dates.

There is also a "group" attribute to join the names of the appointments made on the same time-slot (for time-slots with multiple capacity):

    [CPABC_APPOINTMENT_LIST group="yes"]

The "fields" can be used to modify the columns to display, that field accepts the following items (uppercase):

    CALENDAR
    DATE
    TIME
    NAME
    PHONE
    COMMENTS

... however, in most cases, probably you don't want to display the phone or comments.

The styles for the list are located at the end of the file "all-css.css":

    .cpabc_field_0, .cpabc_field_1, .cpabc_field_2, ...

Clear the browser cache if the list isn't displayed in a correct way (to be sure it loads the updated styles).

= Opening the Calendar in a Different Month =  

There is a field in the settings area named "Open calendar in this initial month/year". This can be used to display the calendar initially in a specified month. This is useful, for example, for bookings of an event that will happen in a future month, so you can display the calendar exactly on that month.

= Allowing Booking Multiple Appointment Slots =  

These settings fields are available for each appointment calendar:

* **Minimum slots to be selected:** This is the minimum number of slots that the customer must select in the booking form.

* **Maximum slots to be selected:** This is the maximum number of slots that the customer can select in the booking form.

* <strong>Close floating panel after selecting a time-slot?:</strong> Default: "Yes". Set to "No" in the case the user has to select various slots in the same date. The price should be set for each total number of slots below (request cost setting).

Note that the **request cost** field will be automatically updated for allowing entering the price for each number of time-slots, giving total freedom at this price setting.

 
= Exporting Appointments to CSV / Excel Files =  

The appointment data can be exported to a CSV file (Excel compatible) to manage the data from other applications. That option is available from the "bookings list", the appointments can be filtered by date and by the text into them, so you can export just the needed appointments to the CSV file.
 
 
= Appointment Calendar Theme Selection =  
 
The current Appointment Booking Calendar version has three pre-built CSS themes:

* Default - Classic
* Light
* Blue

The theme can be selected into the administration area, below the calendar on the settings field labeled "Calendar visual theme". Once selected a new theme, the CSS file "all-css.css" will be loaded from a different subfolder, be sure to edit the related CSS file if you need further modifications to the appointment booking calendar theme styles.
 
= Other Versions and Features = 
 
The free version published in this WordPress directory is a fully-functional version for accepting appointments through PayPal as indicated in the plugin description. There is also a pro (commercial)  version that includes the following additional features (not present in the free version):

- Ability to process forms/appointments without PayPal
- Coupons / discount codes
- Form builder for a visual customization of the booking form
- Email reminders for the appointments
- Additional drop-down fields for multiple prices/services

Please note that the pro features aren't advised as part of the free plugin in the description shown in this WordPress directory. If you are interested in more information about the pro features go to the plugin's page: https://abc.dwbooster.com/download
 
The Appointment Booking Calendar plugin has recently reached **28,000 installations** and we would like to **thank you all the people** that have supported the development of the plugin with feedback messages or by acquiring the pro / developer versions. We are working in a new set of features for all the distributions of the plugin that will be published soon. 
 
== Screenshots ==

1. Appointment booking form.
2. Inserting an appointment calendar into a page.
3. Managing the appointment calendar.
4. Defining time-slots on the appointment calendar
5. Appointment Booking Calendar settings.

== Changelog ==

= 1.0.1 =
* Interface modifications.
* Compatible with WP 3.6
* More features added
* Fixing tags in wp directory
* Two additional calendar themes added
* Tested and fully compatible with WordPress 3.7.x
* Language updates to make them compatible with the latest WP versions

= 1.1.3 =
* Interface modifications.
* New admin settings
* New translations added
* Fixed bug in multisite installations
* PayPal Sandbox mode added
* Fixed warning that appeared with PHP safe mode restrictions 
* Sanitized GET parameters used in queries
* Fixed issue with the site home URL in WP with folders in non-default locations

= 1.1.4 =
* Fixed bug in the function that generates the https url
* Sanitized query parameters
* Fixed bug that caused the Sunday not being selectable in the calendar.
* Automatically repaid corrupted databases
* Fixed SQL issues and improved database structure
* Compatible with the latest WordPress 4.2.x version

= 1.1.6 =
* Removed incorrect parameter from product name forwarded to PayPal
* Fixed: IPN address was generating an incorrect address under SSL environments
* Updated the Export to CSV function to include manually added appointments
* Removed feature that auto-fills the name and email due to multiple user requests
* Update to the captcha image generation to add the content size

= 1.1.7 =
* Compatible with WordPress 4.3
* Replaced h2 to h1 headers for WordPress 4.3
* Fixed bug in ajax loading
* Dutch language updated.

= 1.1.8 =
* Fixed XSS and SQL injection vulneravilities

= 1.1.9 =
* Fixed bug in settings submission

= 1.1.10 =
* Fixed bug in admin area
* New options for appointments slots

= 1.1.11 =
* New options for adding appointments.

= 1.1.12 =
* Added access to the calendars for subscribers

= 1.1.13 =
* Fixed menu slug to match the plugin name.

= 1.1.14 =
* Increased max number of slots in a single booking

= 1.1.15 =
* Tested and compatible with WordPress 4.4
* Fixed bug in query filter

= 1.1.16 =
* Fixed CSS issues in the new WP theme

= 1.1.17 =
* Fixed issues in captcha filess

= 1.1.18 =
* Fixed typo in settings
* Fixed null value issue in query

= 1.1.19 =
* Improved query security

= 1.1.20 =
* Added upgrade referrer

= 1.1.21 =
* Fixed captcha issue in Win serve

= 1.1.22 =
* Improved captcha security

= 1.1.23 =
* Admin intf. updates.

= 1.1.24 =
* Security related to SQL injection
* Language updates

= 1.1.25 =
* Added nonces and other security updates

= 1.1.26 =
* Fixed PHP session issues

= 1.1.27 =
* Shortcode paramters sanitization

= 1.1.28 =
* Updated API URLs

= 1.1.29 =
* Added Catalan language

= 1.1.30 =
* Additional POST params sanitization

= 1.1.31 =
* Added nonces to calendar settings

= 1.1.32 =
* Fixed bug in booking form

= 1.1.33 =
* Added reply-to header to emails

= 1.1.34 =
* Tested in WP 4.5

= 1.1.35 =
* Added Stripcslashes to post

= 1.1.36 =
* SQL query optimizations

= 1.1.37 =
* Fixed bug in calendars list

= 1.1.38 =
* Old changelogs placed in changelog.txt

= 1.1.39 =
* Changed init actions to plugins_loaded

= 1.1.40 =
* Use of less DB queries

= 1.1.41 =
* Deleted old versions of the Appointment Booking Calenadr

= 1.1.42 =
* Timezone difference set to zero

= 1.1.43 =
* Fix in "from" email address

= 1.1.44 =
* Fixed issues in previous update

= 1.1.45 =
* iCal bug fixed

= 1.1.46 =
* GET params sanitized

= 1.1.47 =
* From email auto-formatted

= 1.1.48 =
* Added Norwegian language

= 1.1.49 =
* New options for mindate

= 1.1.50 =
* New translations

= 1.1.51 =
* Compatible with WP 4.6

= 1.1.52 =
* New website and documentation

= 1.1.53 =
* New doc and support URLs

= 1.1.54 =
* Fix to the placeholder from email for compatibility with WP 4.6

= 1.1.55 =
* Modified POST processing

= 1.1.56 =
* Updates to export feature

= 1.1.57 =
* Fixed magic quotes issue

= 1.1.58 =
* Misc code improvements

= 1.1.59 =
* Interface update

= 1.1.60 =
* Update to Hungarian language

= 1.1.61 =
* Update to French language

= 1.1.62 =
* Replaced default placeholder email

= 1.1.63 =
* Better support tracking

= 1.1.64 =
* Database updates

= 1.1.65 =
* PayPal IPN improvements

= 1.1.66 =
* Added korean calendar

= 1.1.67 =
* List option updated

= 1.1.68 =
* Compatible with WP 4.7

= 1.1.69 =
* Removed use of iconv

= 1.1.70 =
* PayPal integration improvement

= 1.1.71 =
* Instructions update

= 1.1.72 =
* Database fix

= 1.1.73 =
* New support page

= 1.1.74 =
* DB update

= 1.1.75 =
* Database improvements

= 1.1.76 =
* Improvements to calendars list

= 1.1.77 =
* Improved view in mobile devices

= 1.1.78 =
* Admin interface modification

= 1.1.79 =
* Removed jquery scripts not longer needed

= 1.1.80 =
* Product name update

= 1.1.81 =
* DB fix for upgrades

= 1.1.82 =
* Dashboard updates

= 1.1.83 =
* Option to add more time slots

= 1.1.84 =
* PayPal button update

= 1.1.85 =
* Help link update

= 1.1.86 =
* Compatible with WP 4.7.3

= 1.1.87 =
* Update related to the parameters in the PayPal IPN notification

= 1.1.88 =
* Use less parameters for the PayPal IPN notification

= 1.1.89 =
* Code improvements

= 1.1.90 =
* Field specialDates now supports more information

= 1.1.91 =
* Mobile friendly update(email types for fields)

= 1.1.92 =
* New anti-spam rule for public booking form

= 1.1.93 =
* Corrected bug in anti-spam rule 

= 1.1.94 =
* Captcha code security and speed improvements
* Better SQL query sanitization through $wpdb->prepare

= 1.1.95 =
* Optional review panel

= 1.1.96 =
* Review panel correction

= 1.1.97 =
* Better CSS styles linking in admin area

= 1.1.98 =
* Sanitization for PayPal email address

= 1.1.99 =
* MySQL query sanitization

= 1.2.10 =
* Tested and compatible with WordPress 4.8

= 1.2.11 =
* Removed deprecated PayPal parameters

= 1.2.12 =
* Cleanup for PayPal parameters

= 1.2.14 =
* Validation and accessibility updates

= 1.2.15 =
* iCal URL modified to prevent issues with robots.txt restrictions

= 1.2.16 =
* Moved plugin website and links to SSL

= 1.2.17 =
* Removed use of deprecated MySQL functions

= 1.2.18 =
* Database installation bug fixed

= 1.2.19 =
* PayPal return address santized

= 1.2.20 =
* Server time note in iCal settings

= 1.2.21 =
* Improved print view

= 1.2.22 =
* Better PayPal currency selection

= 1.2.23 =
* Formatting for price number

= 1.2.24 =
* Automatic validation of price settings

= 1.2.25 =
* Default values for get_option actions

= 1.2.26 =
* Admin settings validation improvements

= 1.2.27 =
* Color fields for captcha settings

= 1.2.28 =
* Admin intf updates

== Upgrade Notice ==

= 1.2.28 =
* Admin intf updates