Þ    C      4  Y   L      °  [   ±  \     U   j  )   À  @   ê    +     ­     º     Â     ×  r   Ý  
   P	     [	  	   m	     w	     	     	     ­	     »	     Ä	     Ò	     R
     Y
     e
  $   k
     
     
     
     ¢
     º
  	   Ã
  3   Í
  9     
   ;     F     U     d     k     n     s            	   «     µ  &   ¾     å     ê  @   ï     0  â   6          ¡  /   §     ×     Þ     ñ  :   ý     8  P   ?            &        Å  ±  É  p   {  o   ì  ¸  \  W     [   m  q   É  .   ;  `   j  K  Ë          +     ;     W     d     ÷     
  	        '     @     V     u            ­   ®     \     c     j  $   p               ¢     ¯     Î     Õ  S   Ý  ^   1                µ     Ê  	   Ñ     Û  	   â     ì  $   õ  	        $  (   4     ]  	   d  q   n  	   à  #  ê          ®  <   »  	   ø            N   (     w  t   ~     ó     ú  (   
     3     :     [!     ß!        
      C   :   +   B       #   1   '      9           *       8      @   "          	                  =       ?   $   2             6                   &         )   !            .       0          %            3          A   >   4              ,                   /          7             <      ;   (   5          -     It executes an HTTP GET passing the caller number as argument to retrieve the correct name  It executes an HTTPS GET passing the caller number as argument to retrieve the correct name  Use DNS to lookup caller names, it uses ENUM lookup zones as configured in enum.conf  Use OpenCNAM [https://www.opencnam.com/]  use astdb as lookup source, use phonebook module to populate it A Lookup Source let you specify a source for resolving numeric CallerIDs of incoming calls, you can then link an Inbound route to a specific CID source. This way you will have more detailed CDR reports with information taken directly from your CRM. You can also install the phonebook module to have a small number <-> name association. Pay attention, name lookup may slow down your PBX Account SID: Actions Add CIDLookup Source Admin Allows CallerID Lookup of incoming calls against different sources (OpenCNAM, MySQL, HTTP, ENUM, Phonebook Module) Auth Token CID Lookup Source CIDLookup Cache Results CallerID Lookup CallerID Lookup Sources Character Set Database Database Name Decide whether or not cache the results to astDB; it will overwrite present values. It does not affect Internal source behavior Delete Description ENUM: Enter a description for this source. HTTP: HTTPS: Host Host name or IP address Internal Internal: It queries a MySQL database to retrieve caller name MySQL Character Set. Leave blank for MySQL default latin1 MySQL Host MySQL Password MySQL Username MySQL: No None Not yet implemented OpenCNAM OpenCNAM Throttle Reached! OpenCNAM: Password Password to use in HTTP authentication Path Port Port HTTP(s) server is listening at (default http 80, https 443) Query Query string, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: number=[NUMBER]&source=crm<br/>'[NAME]' will be replaced with existing caller id name<br/>'[LANGUAGE]' will be replaced with channel language Query, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: SELECT name FROM phonebook WHERE number LIKE '%[NUMBER]%' Reset Select the source type, you can choose between: Source Source Description Source type Sources can be added in Caller Name Lookup Sources section Submit There are %s DIDs using this source that will no longer have lookups if deleted. Type Username Username to use in HTTP authentication Yes You have gone past the free OpenCNAM usage limits.<br/><br/>To continue getting caller ID name information, you need to create an OpenCNAM Professional Account.<br/><br/>You can create an OpenCNAM account at: <a href="https://www.opencnam.com/register">https://www.opencnam.com/register</a>.<br/><br/>Once you have created an account, visit the CallerID Lookup Sources menu and enter your OpenCNAM Professional Tier credentials.<br/> Your OpenCNAM Account SID. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard Your OpenCNAM Auth Token. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard Project-Id-Version: FreePBX 2.10.0.1
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2019-12-26 22:18+0000
PO-Revision-Date: 2015-07-27 13:28+0200
Last-Translator: Kevin <kevin@qloog.com>
Language-Team: Japanese <http://weblate.freepbx.org/projects/freepbx/cidlookup/ja_JP/>
Language: ja_JP
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Weblate 2.2-dev
  ååãæ½åºããããã«ãçä¿¡çªå·ãå¥ãã¦HTTP GETãå®è¡ãã¾ãã  ååãæ½åºããããã«ãçºä¿¡èçªå·ãå¥ãã¦HTTPS GETãå®è¡ãã¾ãã  enum.confã§è¨­å®ããENUMã«ãã¯ã¢ããã¾ã¼ã³ãåã«DNSçµç±ã§çºä¿¡èæå ±ãåå¾ãã¾ãã  OpenCNAMãä½¿ç¨ [https://www.opencnam.com/]  astdbããæå ±ãåå¾ãã¾ããphonebookã¢ã¸ã¥ã¼ã«ããæå ±ãç»é²ãã¾ãã æ¤ç´¢ã½ã¼ã¹ã«ãã£ã¦ãçä¿¡å¼ã®è¨å¤§ãªçºä¿¡èçªå·ãè§£æ±ºããããã«ã½ã¼ã¹ãç¹å®ãããã¨ãã§ãã¾ããããã¦ãã¤ã³ãã¦ã³ãã«ã¼ããç¹å®ã®çºä¿¡èçªå·ã½ã¼ã¹ã«ãªã³ã¯ãããã¨ãã§ãã¾ãããã®æ¹æ³ã«ãã£ã¦ãCRMãããã¤ã¬ã¯ãã«åå¾ããæå ±ãæã¤CDã¬ãã¼ããå¾ããã¨ãã§ãã¾ããå°ããçªå·<->ååã®é¢é£ä»ããæã¤ããã«ãé»è©±å¸³ã¢ã¸ã¥ã¼ã«ãã¤ã³ã¹ãã¼ã«ãããã¨ãã§ãã¾ããæ³¨æãååã®æ¤ç´¢ã¯PBXãéããããã¨ãããã¾ãã ã¢ã«ã¦ã³ãSID: ã¢ã¯ã·ã§ã³ CIDLookupã½ã¼ã¹ãè¿½å  ã¢ããã³ å¥ã®ã½ã¼ã¹ã«å¯¾ãã¦ãçä¿¡å¼ã®çºä¿¡èçªå·ã®æ¤ç´¢ãè¨±å¯ããï¼OpenCNAM, MySQLãHTTPãENUMãé»è©±å¸³ã®ã¢ã¸ã¥ã¼ã«ï¼ èªè¨¼ãã¼ã¯ã³ CIDæ¤ç´¢ã½ã¼ã¹ CIDLookup çµæãã­ã£ãã·ã¥ çºä¿¡èçªå·æ¤ç´¢ çºä¿¡èçªå·æ¤ç´¢ã½ã¼ã¹ æå­ã³ã¼ã ãã¼ã¿ãã¼ã¹ ãã¼ã¿ãã¼ã¹å astDBã¸ã®çµæãã­ã£ãã·ã¥ãããã©ãããæ±ºå®ãã¾ãï¼ç¾å¨ã®å¤ãä¸æ¸ããã¾ããã¤ã³ã¿ã¼ãã«ã½ã¼ã¹ã®æåã«ã¯å½±é¿ãã¾ããã åé¤ èª¬æ ENUM: ãã®ã½ã¼ã¹ã®èª¬æãå¥åã HTTP: HTTPS: ãã¹ãå ãã¹ãå or IPã¢ãã¬ã¹ åé¨ åé¨: MySQLãã¼ã¿ãã¼ã¹ã«ã¯ã¨ãªãããã¦çºä¿¡èæå ±ãåå¾ãã¾ãã MySQLã®æå­ã³ã¼ããç©ºã«ããã¨ãMySQLããã©ã«ãã®latin1ã«è¨­å®ããã¾ã MySQL ãã¹ã MySQLãã¹ã¯ã¼ã MySQLã¦ã¼ã¶ã¼å MySQL: ããã ãªã æªå®è£ OpenCNAM OpenCNAM å¶éã«éãã¾ããï¼ OpenCNAM: ãã¹ã¯ã¼ã HTTPèªè¨¼ã§ä½¿ç¨ãããã¹ã¯ã¼ã ãã¹ ãã¼ã HTTPãè¥ããã¯HTTPSãµã¼ãã¼ãå¾ã¡æ§ãã¦ãããã¼ãçªå· (ããã©ã«ã http 80ãhttps 443) ã¯ã¨ãª ã¯ã¨ãªã®ã¹ããªã³ã°ã'[NUMBER]' ã¯ãã¯ã¨ãªããããã¨ãã«çºä¿¡èçªå·ã«ä¸æ¸ãããã¾ãã<br/>ä¾: number=[NUMBER]&source=crm<br/>'[NAME]' ããããã¨æ¢å­ã®CIDåã«ä¸æ¸ããã¾ãã<br/>'[LANGUAGE]' ã¯Asteriskãã£ãã«ã®è¨èªã«ãªãã¾ãã ã¯ã¨ãªã¼ãç¹æ®ãã¼ã¯ã³'[NUMBER]'ã¯ãçºä¿¡èçªå·ã«ç½®ãæããã¾ãã<br/>ä¾ï¼SELECT name FROM phonebook WHERE number LIKE '%[NUMBER]%' ãªã»ãã ã½ã¼ã¹ã®ç¨®é¡ãä»¥ä¸ããé¸æãã¦ãã ããã ã½ã¼ã¹ ã½ã¼ã¹ã®èª¬æ ã½ã¼ã¹ã®ç¨®é¡ ã½ã¼ã¹ã¯çºä¿¡èåæ¤ç´¢ã½ã¼ã¹ã»ã¯ã·ã§ã³ã§è¿½å ã§ãã¾ãã éä¿¡ ãã®ã½ã¼ã¹ãä½¿ç¨ãã¦ãããã¤ã¤ã«ã¤ã³ã%såãããåé¤ããå ´åã¯æ¤ç´¢ã§ãã¾ããã ç¨®é¡ ã¦ã¼ã¶ã¼å HTTPèªè¨¼ã§ä½¿ç¨ããã¦ã¼ã¶ã¼å ã¯ã OpenCNAMã®ç¡æå©ç¨å¶éãè¶éãã¾ããã<br/><br/>caller IDåæå ±ã®åå¾ãç¶ããã«ã¯ãOpenCNAMãã­ãã§ãã·ã§ãã«ã¢ã«ã¦ã³ããä½æããå¿è¦ãããã¾ãã<br/><br/>ä½æããã«ã¯ ï¼<a href="https://www.opencnam.com/register">https://www.opencnam.com/register</a>ã«ã¢ã¯ã»ã¹ãã¦ãã ããã<br/><br/>ã¢ã«ã¦ã³ãä½æå¾ãCallerIDã«ãã¯ã¢ããã½ã¼ã¹ã®ã¡ãã¥ã¼ãéããã¢ã«ã¦ã³ãæå ±(OpenCNAM Professional Tier credentials)ãå¥åãã¦ãã ããã<br/> OpenCNAMã®ã¢ã«ã¦ã³ãSIDãOpenCNAMã®ããã·ã¥ãã¼ããã¼ã¸ã§ç¢ºèªã§ãã¾ãï¼https://www.opencnam.com/dashboard OpenCNAMã®èªè¨¼ãã¼ã¯ã³ãOpenCNAMã®ããã·ã¥ãã¼ããã¼ã¸ã§ç¢ºèªã§ãã¾ãï¼https://www.opencnam.com/dashboard 