��    H      \  a   �         [   !  \   }  U   �  )   0  @   Z  �   �  �  L     �	     �	     �	     �	  r   �	  
   q
     |
  	   �
     �
     �
     �
     �
     �
     �
     �
     s     z     �  $   �     �     �     �     �     �  	   �  3   �     "  9   /  
   i     t     �     �     �     �     �     �      �     �  	   �       &        4    9     <  @   A     �  �   �  �   k     �  /   �     )     0     C  :   O     �  P   �     �  w   �     _  &   h     �  �  �  p   E  o   �  �  &  v   �  v   L  �   �  1   V  �   �  �       �     �     �          (  �   ;     �     �     �     �               8     F     [  �   u     <     A     J  '   P     x     ~     �      �  
   �     �  O   �       D   *  
   o     z     �     �     �     �     �     �     �  )        B     b  /   o     �  K  �     �   P   !  
   _!    j!  �   �"     7#  5   I#     #     �#     �#  {   �#  	   #$  h   -$     �$  �   �$     H%  /   \%     �%    �%  �   �'  �   7(     )   5      G   :          6   4          ?   ;                     8       2   '              /   #             @                         D   B   =   %             H   F   (   	       0   .   C             +   
          A   !   $      <                         E   >                           *   9      ,   7      1   "         &   3             -         It executes an HTTP GET passing the caller number as argument to retrieve the correct name  It executes an HTTPS GET passing the caller number as argument to retrieve the correct name  Use DNS to lookup caller names, it uses ENUM lookup zones as configured in enum.conf  Use OpenCNAM [https://www.opencnam.com/]  use astdb as lookup source, use phonebook module to populate it <p>If you need to create an OpenCNAM account, you can visit their website: <a href="https://www.opencnam.com/register" target="_blank">https://www.opencnam.com/register</a></p> A Lookup Source let you specify a source for resolving numeric CallerIDs of incoming calls, you can then link an Inbound route to a specific CID source. This way you will have more detailed CDR reports with information taken directly from your CRM. You can also install the phonebook module to have a small number <-> name association. Pay attention, name lookup may slow down your PBX Account SID: Actions Add CIDLookup Source Admin Allows CallerID Lookup of incoming calls against different sources (OpenCNAM, MySQL, HTTP, ENUM, Phonebook Module) Auth Token CID Lookup Source CIDLookup Cache Results CallerID Lookup CallerID Lookup Sources Character Set Database Database Name Decide whether or not cache the results to astDB; it will overwrite present values. It does not affect Internal source behavior Delete Description ENUM: Enter a description for this source. HTTP: HTTPS: Host Host name or IP address Internal Internal: It queries a MySQL database to retrieve caller name List Sources MySQL Character Set. Leave blank for MySQL default latin1 MySQL Host MySQL Password MySQL Username MySQL: No None Not yet implemented OpenCNAM OpenCNAM Requires Authentication OpenCNAM Throttle Reached! OpenCNAM: Password Password to use in HTTP authentication Path Path of the file to GET<br/>e.g.: /cidlookup.php<br>Special token '[NUMBER]' will be replaced with caller number<br/>e.g.: /cidlookup/[NUMBER]/<br/>'[NAME]' will be replaced with existing caller id name<br/>'[LANGUAGE]' will be replaced with channel language Port Port HTTP(s) server is listening at (default http 80, https 443) Query Query string, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: number=[NUMBER]&source=crm<br/>'[NAME]' will be replaced with existing caller id name<br/>'[LANGUAGE]' will be replaced with channel language Query, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: SELECT name FROM phonebook WHERE number LIKE '%[NUMBER]%' Reset Select the source type, you can choose between: Source Source Description Source type Sources can be added in Caller Name Lookup Sources section Submit There are %s DIDs using this source that will no longer have lookups if deleted. Type Unauthenticated calls to the OpenCNAM API will soon fail. You will need an OpenCNAM account to continue using their API Username Username to use in HTTP authentication Yes You have gone past the free OpenCNAM usage limits.<br/><br/>To continue getting caller ID name information, you need to create an OpenCNAM Professional Account.<br/><br/>You can create an OpenCNAM account at: <a href="https://www.opencnam.com/register">https://www.opencnam.com/register</a>.<br/><br/>Once you have created an account, visit the CallerID Lookup Sources menu and enter your OpenCNAM Professional Tier credentials.<br/> Your OpenCNAM Account SID. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard Your OpenCNAM Auth Token. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard Project-Id-Version: PACKAGE VERSION
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2019-02-20 18:35-0500
PO-Revision-Date: 2017-07-14 10:19+0200
Last-Translator: PETER <ftek@ymail.com>
Language-Team: Vietnamese <http://weblate.freepbx.org/projects/freepbx/cidlookup/vi/>
Language: vi
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Weblate 2.4
  Nó thực hiện một HTTP GET truyền qua số người gọi như một đối số để lấy tên chính xác  Nó thực hiện một HTTP GET truyền qua số người gọi như một đối số để lấy tên chính xác  Sử dụng NDS để tra cứu tên người gọi, nó sử dụng những vùng tra cứu ENUM  như đã được cấu hình trong enum.conf  Sử dụng OpenCNAM [https://www.opencnam.com/]  Sử dụng astdb như nguồn tra cứu, sử dụng mô đun phonebook (danh bạ điện thoại) để đưa nó vào danh bạ <p> Nếu bạn cần tạo môt tài khoản OpenCNAM, bạn có thể truy cập website <a href="https://www.opencnam.com/register" target="_blank">https://www.opencnam.com/register</a></p> Một nguồn tra cứu sẽ cho phép bạn xác định một nguồn để giải quyết các CallerIDs của các cuộc gọi đến, sau đó bạn có thể nối các tuyến gọi vào để xác định nguồn CID. Bằng cách này bán ẽ có các báo cáo CDR chi tiết hơn với các thông tin được thu thập trực tiếp tuwg CRM của bạn. Bạn cũng có thể cài đặt mô đun phonebook để có những số điện thoại nhỏ <-> Nhóm tên. Chú ý, tra cứu tên sẽ làm chậm PBX của bạn Tài khoản SID: Các thao tác Thêm ngồn tra cứu CID Quản trị viên Cho phép Tra cứu CallerID các cuộc gọi đến cho các nguồn khác nhau (OpenCNAM, MySQL, HTTP, ENUM, Phonebook Module) Thẻ xác thực Nguồn tra cứu CID Tra cứu CID Kết quả Cache Tra cứu CallerID Các nguồn tra cứu CallerID Bộ ký tự Cơ sở dữ liệu Tên cơ sở dữ liệu Quyết định có hay không các kết quả bộ nhớ cache đến astDB; Nó sẽ ghi đè lên các giá trị hiện tại. Nó không ảnh hưởng đến hành vi của nguồn nội bộ Xóa Mô tả ENUM: Nhập một mô tả cho nguồn này. HTTP: HTTPS: Host Tên host hoặc địa chỉ IP Nội bộ Nội bộ: Nó yêu cầu một cơ sở dữ liệu MySQL để lấy tên người gọi Danh sách các nguồn Bộ ký tự MySQL. Để trống cho mặc định MySQL la tinh 1 Host MySQL Mật khẩu MySQL Tên người dùng MySQL MySQL: Không Không Chưa được thực hiện Dịch vụ tra cứu OpenCNAM OpenCNAM yêu cầu Xác thực Đã kết nối với OpenCNAM Throttle! Dịch vụ tra cứu OpenCNAM: Mật khẩu Mật khẩu sử dụng trong xác thực HTTP Đường dẫn Đường dẫn của tệp đến GET <br/>e.g.: /cidlookup.php<br>Special token '[NUMBER]' sẽ được thay thế bằng một số người gọi <br/>e.g.: 
/cidlookup/[NUMBER]/<br/>'[NAME]'  sẽ được thay thế với tên ID người gọi hiện có <br/>'[LANGUAGE]'  sẽ được thay thế bằng ngôn ngữ kênh Cổng giao tiếp Cổng giao tiếp máy chủ HTTP đang nghe tại (default http 80, https 443) Truy vấn Chuỗi truy vấn. token đặc biệt  '[NUMBER]' sẽ được thay thế với số người gọi <br/>e.g.: number=[NUMBER]&source=crm<br/>'[NAME]' sẽ được thay thế với tên caller id hiện có <br/>'[LANGUAGE]' sẽ được thay thế với ngôn ngữ kênh Truy vấn, token đặc biệt '[NUMBER]' sẽ được thay thế với số người gọi <br/>e.g.:CHỌN tên TỪ danh bạ điện thoại NƠI số giống LIKE '%[NUMBER]%' Cài đặt lại Chọn kiểu nguồn, bạn có thể chọn giữa: Nguồn Mô tả nguồn Kiểu nguồn Các nguồn có thể được thêm trong phần Caller Name Lookup Sources ( Các nguồn tra cứu tên người gọi) Gửi đi Có %s DIDs đang sử dụng nguồn này nếu xóa điều này sẽ không được tra cứu nữa. Kiểu Các cuộc gọi không được xác thực đến OpenCNAM API sẽ sớm thất bại. Bạn sẽ cần một tài khoản OpenCNAM để tiếp tục sử dụng API Tên người dùng Tên người dùng cho việc xác thực HTTP Có Bạn đã quá thời hạn sử dụng OpenCCAM miễn phí. <br/><br/> để tiếp tục có thông tin tên caller ID, bạn cần rạo một tài khoản OpenCNam chuyên nghiệp. <br/><br/> Bạn có thể tạo một tài khoản OpenCNAM tại <a href="https://www.opencnam.com/register">https://www.opencnam.com/register</a>.<br/><br/>Khi bạn tạo một tài khoản, truy cập Menua nguồn tra cứu CallerID và nhập các thông tin đăng nhập  OpenCNAM Professional Tier  của mình.<br/> Mở SID tài khoản OpenCNAM của bạn. Điều này có thể tìm thấy trên trang điều khiển OpenCNAM của bạn: https://www.opencnam.com/dashboard Token xác thực OpenCNAM của bạn. Token này có sẽ được tìm thấy trên trang điều khiển OpenCNAM:  https://www.opencnam.com/dashboard 