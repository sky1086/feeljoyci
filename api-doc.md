#Web API details #
API domain = https://api.feeljoy.in

**<domain>/apis/user/isLoggedIn**  
Check if user is logged in  
**Request -** GET  
**Params -** None  
**Response - **  
In case of no login - {"error":true,"login":"required"}  
If user already logged in - {"userid":"10","username":"sanjeev@test.in","contactname":"Saanjeev","email":"sanjeev@test.in","profileimage":"https:\/\/api.feeljoy.in\/pics_listener\/","usertype":"User"}

  
**<domain>apis/login**  
Used to make a user logged into system  
**Request -** POST  
**Params -**  
username=\*username\*  
password=\*password\*  
**Response -** {"error":true,"message":"Invalid username or password"}  
Currently its redirect to a web page, we need to update this API.  

  
**<domain>/apis/signup**  
Sign up user  
**Request -** POST  
**Params -**  
email=\*example@email.com\*  
password=\*password\*  
**Response -** {"message":"User signup successfully.","error":false}  

  
**<domain>/apis/signup/details**  
Second step add user other details  
**Request -** POST  
**Params -**  
email=\*example@email.com\*  
contact_name=\*sanjeev\*  
age=\*31\*  
gender=\*male\*  
**Response -** This redirect to home page for the user.  

**<domain>/apis/user/listeners**  
Listeners list API(without login) -    
**Request -** GET   
**Response -** [{"id":"26","name":"Akshita","qualification":"Love Playing T.T & Painting","interests":"Playing T.T ","gender":"Female","tagline":"Believe in You ","profile_img":"https:\/\/api.feeljoy.in\/pics_listener\/sakshi.jpg","link":"https:\/\/api.feeljoy.in\/user\/chat\/index\/26","profile_link":"https:\/\/api.feeljoy.in\/listener\/details\/index\/26","priority":"1","practice_area":"Balancing Home & Academics"},{"id":"4247575470","name":"Anushka ","qualification":null,"interests":"Dancing, Reading novels ","gender":"Female","tagline":"Asking for help is a mark of courage","profile_img":"https:\/\/api.feeljoy.in\/pics_listener\/man.png","link":"https:\/\/api.feeljoy.in\/user\/chat\/index\/4247575470","profile_link":"https:\/\/api.feeljoy.in\/listener\/details\/index\/4247575470","priority":"2","practice_area":"Anger Management "},{"id":"3499177431","name":"Arohi ","qualification":null,"interests":"Dancing ","gender":"Female","tagline":"It's the direction that matters, not the speed.","profile_img":"https:\/\/api.feeljoy.in\/pics_listener\/man.png","link":"https:\/\/api.feeljoy.in\/user\/chat\/index\/3499177431","profile_link":"https:\/\/api.feeljoy.in\/listener\/details\/index\/3499177431","priority":"3","practice_area":"Low Self-Esteem"},{"id":"35","name":"Priya","qualification":"Sports Enthusiast ","interests":"Travelling, Reading books","gender":"Female","tagline":"The key is not to prioritize what's on your schedule, but to schedule your Priorities.","profile_img":"https:\/\/api.feeljoy.in\/pics_listener\/man.png","link":"https:\/\/api.feeljoy.in\/user\/chat\/index\/35","profile_link":"https:\/\/api.feeljoy.in\/listener\/details\/index\/35","priority":"4","practice_area":"Stress"},{"id":"105","name":"Samaira","qualification":"Xyz","interests":"Singing","gender":"Female","tagline":"You don't find yourself in your peaks, but your valleys.","profile_img":"https:\/\/api.feeljoy.in\/pics_listener\/man.png","link":"https:\/\/api.feeljoy.in\/user\/chat\/index\/105","profile_link":"https:\/\/api.feeljoy.in\/listener\/details\/index\/105","priority":"6","practice_area":"Anxiety"}]  

**<domain>/apis/user/listenerChatList**  
Listener list(chat with at least once) - login required.   
**Request -** GET  
**Response -** {"error":true,"login":"required"}  
Otherwise  
List of listeners


**Guide API's**  
**<domain>/apis/guide**  
**Request -** GET  
**Response -**  
[{"name":"Academic","url":"academic"},{"name":"Life Skills ","url":"life-skills"},{"name":"Relationship","url":"relationship"},{"name":"What is ?","url":"what-is"}]


**After First click apis**  
**<domain>/apis/guide/clicks/academic**  
**Request -** GET  
**Response -**  
[{"name":"Low Self-Esteem","url":"low-selfesteem"},{"name":"Balancing Home & Academics","url":"balancing-home--academics"},{"name":"Peer Pressure","url":"peer-pressure"},{"name":"Chronic Illness","url":"chronic-illness"},{"name":"Feeling lost","url":"feeling-lost"},{"name":"Adjusting to Hostel life","url":"adjusting-to-hostel-life"},{"name":"Low scores in Academics","url":"low-scores-in-academics"}]


**After Second Click**  
Since the url and backend page is similar with others, so we need to and one flag to separate answer page from other ones(i.e. answerPage:1). the "answer" property contains array with content for pages. Length of array=number of card pages.
**<domain>/apis/guide/clicks/academic/low-selfesteem**   
**Request -** GET  
**Response -**  
[{"answerPage":1,"question":"Low Self-Esteem","answer":["<p>Self esteem refers to the thoughts, opinions and feelings we have about ourselves. It is our overall opinion of who we are.&nbsp;<\/p>","<p>The following are the ways to maintain a high level of self esteem:<br \/>\n&bull;&nbsp;&nbsp; &nbsp;Control your inner critic. Instead of being overly and unrealistically critical of yourself,<\/p>","<p>challenge these thoughts and acknowledge your strengths<br \/>\n&bull;&nbsp;&nbsp; &nbsp;Aim for effort rather than perfection<br \/>\n&bull;&nbsp;&nbsp; &nbsp;Remind yourself that everyone is different and has different strengths<\/p>","<p>&bull;&nbsp;&nbsp; &nbsp;Distinguish between things that are under your control and those that are not<br \/>\n&bull;&nbsp;&nbsp; &nbsp;Be confident about your ideas and opinions<\/p>","<p>&bull;&nbsp;&nbsp; &nbsp;Engage in self compassion: Recognize the fact that we are all human and we all make mistakes.&nbsp;<\/p>"]}]

 
 **Screening Questions API**  
 **<domain>/apis/screeningquestion/get/<type>**  
**Request -** GET  
**Response -**  
 [{"id":"1","question":"How bothered have you been about your problems in the past month?","q_type":"anxiety","q_status":"1","weightage":"7"},{"id":"2","question":"How often have you given up trying to control worrying about your problems over the past month?","q_type":"anxiety","q_status":"1","weightage":"6"},{"id":"3","question":"How bothered have you been about facing sleep difficulties or having excess drowsiness in the past month?","q_type":"anxiety","q_status":"1","weightage":"5"},{"id":"4","question":"How often have you had changes in your usual appetite in the past month?","q_type":"anxiety","q_status":"1","weightage":"4"},{"id":"5","question":"How often have you been easily irritable or annoyed over the past month?","q_type":"anxiety","q_status":"1","weightage":"3"},{"id":"6","question":"Have you had trouble relaxing over the past month?","q_type":"anxiety","q_status":"1","weightage":"2"},{"id":"7","question":"Have you felt a decreased interest in everyday activities, including hobbies in the past month?","q_type":"anxiety","q_status":"1","weightage":"1"}]