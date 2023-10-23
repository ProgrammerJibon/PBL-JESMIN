<?php header("content-type: text/javascript");
    $index = false;
    require_once"./functions.php";
?>
/* <script type="text/javascript">/**/
function loadLink(url, data){
	// TODO: loadLink('/pages.php', [['name','jibon'],['bool','false']]).then(result=>{console.log(result)})
	return new Promise(function(resolve, reject){

		var http = new XMLHttpRequest();
		http.open("POST", url);
		var formData = new FormData();
		if (data != null) {
			data = [...data];
			data.forEach((post)=>{
			  if (post[0] && post[1]) {
                if (post[1] instanceof File) {
                    formData.append(post[0], post[1], post[1].name);
                } else {
                    formData.append(post[0], post[1]);
                }
			  }
			})
		}
		http.send(formData);
		http.onload=()=>{
			resolve(JSON.parse(http.responseText));
		}
	});
}


function basename(link){
    if (link.length > 0) {
        if(!link.startsWith("https://") && !link.startsWith("http://")){
            const startsWith = window.location.origin;
            link = link.startsWith("/")?startsWith+link:startsWith+"/"+link;
        }
        const url = link?new URL(link):"";
        const pathname = url.pathname.split('/').pop();
        const basename = pathname.split('?')[0];
        return basename;
    }
    return link;
}

function forceDownload(href, title="") {

    title = title!=""?title:basename(href);

	var anchor = document.createElement('a');

	anchor.href = href;

	anchor.download = title;

	document.body.appendChild(anchor);

	anchor.click();

	document.body.removeChild(anchor);

}
function viewToggle(div) {

	div.classList.toggle("show")

}



function timestampToDate(timestamp) {
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var date = new Date(timestamp * 1000);
  var year = date.getFullYear();
  var month = months[date.getMonth()];
  var day = date.getDate();
  var hours = date.getHours();
  var minutes = "0" + date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  var formattedTime = month + ' ' + day + ', ' + year + ' ' + hours + ':' + minutes.substr(-2) + ampm;
  return formattedTime;
}




function viewRemove(div) {

	div.classList.remove("show")

}

const validateEmail = (email) => {

	return String(email)

	.toLowerCase()

	.match(

		/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

	);

};




function create(name, classes = null, id = null){

	if(name != "" && name != null && name != undefined && name != false){

		var element = document.createElement(name);

		if(classes != "" && classes != null && classes != undefined && classes != false){

			classes.split(" ").forEach(item=>{

				if(item != ""){

					element.classList.add(item);

				}				

			});

		}

		if(id != "" && id != null && id != undefined && id != false){

			id.split(" ").forEach(item=>{

				if(item != ""){

					element.id += (" ")+(item);

				}				

			});

		}

		return element;

	}else{

		return false;

	}

}





function byId(id){

	if (document.getElementById(id)) {

		return document.getElementById(id);

	}else{

		return false;

	}

}








function rgba(r, g, b, a){

	if (r < 0 || r > 255) {

		r = 0;

	}

	if (g < 0 || g > 255) {

		g = 0;

	}

	if (b < 0 || b > 255) {

		b = 0;

	}

	if (a < 0 || a > 1) {

		a = 1;

	}

	var data = "rgba("+r+", "+g+", "+b+", "+a+")";

	return data;

}






function notification(text, color){

	if (document.getElementById("event_5")) {

		var view = document.getElementById("event_5");

		var newDiv = document.createElement("div");

		newDiv.classList.add("notification");

		newDiv.innerHTML = text;

		view.appendChild(newDiv);

		newDiv.onclick=e=>{

			setTimeout(v=>{

				newDiv.style = "";

			}, 100);

			setTimeout(v=>{

				newDiv.remove();

			}, 300);

		}

		setTimeout(v=>{

			newDiv.style = "";

		}, 20000);

		setTimeout(v=>{

			newDiv.remove();

		}, 20300);

		var newInterval = setInterval(e=>{

			colorx = rgba(Math.floor(Math.random()*255+1),Math.floor(Math.random()*255+1),Math.floor(Math.random()*255+1), 1);

			newDiv.style = "color:"+colorx+";padding: 8px 16px;height: 35px;border: 1px solid;opacity: 1;border-radius: 3px;font-size: 11px;margin-bottom: 4px;";

		},250);



		setTimeout(v=>{

			newDiv.style = "color:"+color+";padding: 8px 16px;height: 35px;border: 1px solid;opacity: 1;border-radius: 3px;font-size: 11px;margin-bottom: 4px;";

			clearInterval(newInterval);

		}, 3000);

	}else{

		var event_5 = document.createElement("div");

		event_5.id = "event_5";

		document.querySelector("body").appendChild(event_5);

		notification(text, color);

	}

}





function previewInputImage(input, image) {
  var input = input.files[0];
  var reader = new FileReader();

  reader.onload = function () {
	console.log(image);
    image.src = reader.result;
  }

  if (input) {
    reader.readAsDataURL(input);
  } else {
    image.src = "";
  }
}










function href(link){

	if(link){

		window.location.href = (link);

	}

}

function tab(link){

	if(link){

		window.open(link);

	}

}


function keepAlphanumeric(inputString) {
  return inputString.replace(/[^A-Za-z0-9]/g, '');
}




calculateSemester = (currentSessionID, admissionSessionID)=>{
	let semester = currentSessionID - admissionSessionID + 1;
	if(semester>8){
		semester = 8;
	}else if(semester < 0){
		semester = 1;
	}
	if ((semester+"").endsWith("1")) {
		semester+="st";
	}else if ((semester+"").endsWith("2")) {
		semester+="nd";
	}else if ((semester+"").endsWith("3")) {
		semester+="rd";
	}else{
		semester += "th";
	}
	return semester;
}
const subjects = JSON.parse(`<?php echo json_encode($subjects); ?>`);
const departments = JSON.parse(`<?php echo json_encode($departments); ?>`);
const sessions = JSON.parse(`<?php echo json_encode($sessions); ?>`);
const sections = JSON.parse(`<?php echo json_encode($sections); ?>`);
const allStatusMode = JSON.parse(`<?php echo json_encode($allStatusMode); ?>`);
function showPopUpUserDetails(id){
	const body = document.querySelector("body");
	let popUp = body.querySelector(".popUpUserDetails");
	let popUpShadow = body.querySelector(".popUpShadow");
	let popUpUser = body.querySelectorAll(".popUpUser");
	popUpUser.forEach(item=>{
		item.classList.toggle("shown", false);
	});
	if(!popUp){
		popUp = create("div", "popUpUserDetails");
		body.appendChild(popUp);
		popUpShadow = create("div", "popUpShadow");
		popUp.appendChild(popUpShadow);
	}
	let userClassStyle = `user-id-${id}-class`;
	let userDiv = body.querySelector(`.${userClassStyle}`);
	popUp.classList.toggle("shown", true);
	body.style.overflow = "hidden";
	if (userDiv) {
		userDiv.classList.toggle("shown", true);
	}else{
		userDiv = create("div", `${userClassStyle} popUpUser`);
		popUp.appendChild(userDiv);
		userDiv.classList.toggle("shown", true);

		loadLink('/json', [['user_info', id]]).then(result=>{
			console.log(result);
			let isAdmin = false;
			if("user_info" in result){
				const userInfo = result.user_info;

				if(result.type == "ADMIN"){
					isAdmin = true;
				}

				const container = create("form", "user-info-container ame4s7-form");
				
				container.method = "POST";
				container.enctype = "multipart/form-data";
				container.action = "/json";

				
				const picNode = create("img", "profile-pic");
				picNode.src = userInfo.pic;
				container.appendChild(picNode);


				const fnameNode = create("p", "fname");
				fnameNode.innerHTML = `${userInfo.fname}`+" "+userInfo.lname;
				container.appendChild(fnameNode);


				const tableUserData = create("table");
				container.appendChild(tableUserData);

				trTableRowGen = (title, value, type, userAdmin) =>{
					const tr = create("tr");
					const titleTd = create("td");
					tr.appendChild(titleTd);
					titleTd.innerHTML = title;
					const valueTd = create("td");
					tr.appendChild(valueTd);
					if(userAdmin){
						const input = create("input");
						input.name = keepAlphanumeric(title).toLowerCase();
						input.value = value;
						input.placeholder = title;
						input.type = type;
						if (input.type == "file") {
							input.accept = "image/*";
						}else if(input.type != "checkbox"){
							input.required = true;
						}else{
						}
						valueTd.appendChild(input);
						valueTd.style.padding = "0px";
					}else{
						valueTd.innerHTML = value;
					}
					return tr;
				}

				trTableSelectGen = (title, jsonArray, key, value, userAdmin, minId, maxID) =>{
					const tr = create("tr");
					const titleTd = create("td");
					minId = minId?minId:0;
					maxID = maxID?maxID:jsonArray.length;
					tr.appendChild(titleTd);
					titleTd.innerHTML = title;
					const valueTd = create("td");
					tr.appendChild(valueTd);

					const select = create("select");
					select.name = keepAlphanumeric(title).toLowerCase();
					select.value = value;
					valueTd.appendChild(select);
					valueTd.style.padding = "0px";
					if(userAdmin){						
						jsonArray.forEach(object=>{
							object.id = parseInt(object.id);
							if ((minId <= object.id && maxID >= object.id) || key == "") {
								const option = create("option");
								select.appendChild(option);
								if(key){
									if(object.id == value){
										option.selected = true;
									}
									option.innerHTML = object.id+" - "+object[key];
									option.value = object.id;
								}else{
									if(object == value){
										option.selected = true;
									}
									option.innerHTML = object;
									option.value = object;
								}						
								
							}else{
								console.log(minId, maxID, object.id);
							}							
						});
					}else{
						jsonArray.forEach(object=>{
							if(object.id == value || (!key && object == value)){
								const option = create("option");
								select.appendChild(option);
								if(key){
									option.innerHTML = object[key];
									option.value = object.id;
								}else{
									option.innerHTML = object;
									option.value = object;
								}
								option.selected = true;
							}
						});
					}
					return tr;
				}


				tableUserData.appendChild(trTableRowGen("First Name", `${userInfo.fname}`,"text", isAdmin));
				tableUserData.appendChild(trTableRowGen("Last Name", `${userInfo.lname}`,"text", isAdmin));
				tableUserData.appendChild(trTableRowGen("Picture", `${userInfo.lname}`,"file", isAdmin));

				tableUserData.appendChild(trTableRowGen("User ID", `${userInfo.id.toLowerCase()}`));
				userInfo.type == "STUDENT"?tableUserData.appendChild(trTableRowGen("Student ID", `${userInfo.student_id}`)):null;
				tableUserData.appendChild(trTableRowGen("User Type", `${userInfo.type.toLowerCase()}`));

				tableUserData.appendChild(trTableRowGen("NID", `${userInfo.nid_number}`,"text", isAdmin));
				tableUserData.appendChild(trTableRowGen("Phone", `${userInfo.phone}`,"text", isAdmin));
				tableUserData.appendChild(trTableRowGen("Email", `${userInfo.email}`,"text", isAdmin));
				userInfo.type == "TEACHER"?tableUserData.appendChild(trTableRowGen("Username", `${userInfo.username}`,"text", isAdmin)):null;


				userInfo.type == "STUDENT"?tableUserData.appendChild(trTableSelectGen("Section ID", sections, "section_code", `${userInfo.current_section_id}`, isAdmin)):null;
				userInfo.type == "STUDENT"?tableUserData.appendChild(trTableSelectGen("Admission Session ID", sessions, "name", `${userInfo.admission_session_id}`)):null;
				userInfo.type == "STUDENT"?tableUserData.appendChild(trTableSelectGen("Current Session ID", sessions, "name", `${userInfo.current_session_id}`, isAdmin, parseInt(userInfo.current_session_id), parseInt(userInfo.admission_session_id)+8)):null;

				tableUserData.appendChild(trTableSelectGen("Current Department Id", departments, "department_name_full", `${userInfo.current_department_id}`, userInfo.type=="TEACHER"?isAdmin:false));

				userInfo.type == "TEACHER"?tableUserData.appendChild(trTableSelectGen("Current Subject ID", subjects, "subject_code", `${userInfo.current_subject_id}`, isAdmin)):null;

				tableUserData.appendChild(trTableSelectGen("Account Status", allStatusMode, false, `${userInfo.status}`, isAdmin));
				
				userInfo.type == "STUDENT"?tableUserData.appendChild(trTableRowGen("Semester", `${calculateSemester(userInfo.current_session_id, userInfo.admission_session_id)}`)):null;

				tableUserData.appendChild(trTableRowGen("Timestamp", `${userInfo.time}`));

				if(result.edit_pass){
					tableUserData.appendChild(trTableRowGen("Change Password", "","password", result.edit_pass));
				}else if(isAdmin){
					tableUserData.appendChild(trTableRowGen("Reset Password", "1","checkbox", isAdmin));
				}

				

				

				const warningsDiv = create("div");
				warningsDiv.innerHTML += `<div style="color:#0075ff">1. Only sky blue fields can be edited</div>`;
				warningsDiv.innerHTML += `<div style="color:red">2. Asteric (*) fields are required!</div>`;
				isAdmin?container.appendChild(warningsDiv):"";
				

				const editButton = create("button", "ame4s7-button");
				editButton.innerHTML = result.edit_pass?"Change Password":"Edit User Data";
				editButton.name = "edit_user";
				editButton.type = "submit";
				editButton.value = userInfo.id;
				isAdmin || result.edit_pass?container.appendChild(editButton):"";



				userDiv.appendChild(container);

			}
		})
		
	}

	popUpShadow.onclick = e=>{
		popUp.classList.toggle("shown", false);
		userDiv.classList.toggle("shown", false);
		body.style.overflow = "";
	}
	
}









function window_onload(e){
	
}







window.onload=window_onload;