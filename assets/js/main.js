let url=window.location.pathname


window.onload=function(){ 

    if(url=='/admin-page/admin.php' ||
       url=='/admin-page/ad-request.php' ||
       url=='/admin-page/ad.php' ||
       url=='/admin-page/admin.php' ||
       url=='/admin-page/agents-request.php' ||
       url=='/admin-page/agents.php' ||
       url=='/admin-page/adit-profile.php' ||
       url=='/admin-page/messages.php' || 
       url=='/admin-page/edit-profile.php' || 
       url=='/admin-page/poll.php' || 
       url=='/admin-page/message-page.php'){
        setPictureForPagination('../models/allPictures.php')
    }
    else{
        setPictureForPagination('models/allPictures.php')
    }
    if(url=='/index.php') newslatterForm()
    if(url=='/register.php') registerForm()
    if(url=='/log.php') logInForm()
    if(url=='/agent-register.php') agentForm()
    if(url=='/update-profile.php') updateProfileForm()
    if(url=='/properties-insert.php') validationInsertPropertie()
    if(url=='/propertie-page.php')  printPicture() 
    if(url=='/properties.php'){ paginationRealEstates() }  
    if(url=='/contact.php') contactValidation()
    if(url=='/profile.php' || url=='/properties.php') getPicturesFromOneAd()
    if(url=='/admin-page/ad.php') getPicturesForAdmin()
    if(url=='/propertie-page.php')  scheduleValidation() 
    if(url=='/properties.php')  filter() 
    if(url=='/admin-page/agents-request.php') {
        requestForActiveOrDeleteAgent('.agentApprove','idapprove','../models/agent-request.php',printRequest)
        requestForActiveOrDeleteAgent('.agentRequestDelete','agentreqdelete','../models/agent-request-delete.php',printRequest)
    }
    if(url=='/admin-page/agents.php') requestForActiveOrDeleteAgent('.agentDelete','idagent','../models/agent-delete.php',printAgentsList)
    if(url=='/propertie-page.php') approvedAd()
    if(url=='/admin-page/ad.php') requestForActiveOrDeleteAgent('.adDelete','addelete','../models/ad-delete.php',printAdList)
    if(url=='/admin-page/ad-request.php') requestForActiveOrDeleteAgent('.deleteReqAd','deleteadreq','../models/ad-request-delete.php',printAdListRequest)
    if(url=='/admin-page/admin.php') requestForActiveOrDeleteAgent('.deleteUser','userdelete','../models/user-delete.php',printAllUsers)
    if(url=='/admin-page/messages.php') requestForActiveOrDeleteAgent('.deleteMessage','message','../models/message-delete.php',printMessage)
    if(url=='/profile.php'){
        deleteProfileWarning()
        var profileAgent=document.querySelector('#tableProfile')
        if(profileAgent) requestForActiveOrDeleteAgent('.deleteAdUser','iddeletead','models/del.php',deleteAgentAdForHimself)
        
    } 
}

function deleteAgentAdForHimself(array){
    let html=''
    if(array.length!=0){
        for(let x of array){
            html+=`<tr class="red">
            <td>${x.naziv}</td>
            <td>${x.datum_postavljanja}</td>
            <td class="text-center"><a class="btn-potvrdiNek" href="/propertie-page.php?idProp=${x.id_nekretnine}" id="realEstate" data-id="${x.id_nekretnine}"><i class="fa fa-eye"></i></a></td>
            <td class="text-center"><a class="btn-obrisiNek deleteAdUser" href="#"  data-iddeletead="${x.id_nekretnine}"><i class="fa fa-trash"></a></a></td>`
        }
     }
     else{
         html+='<h4 class="text-center">Trenutno nema aktivnih oglasa.</h4>'
     }
  
     document.querySelector('#tableProfile').innerHTML=html
}


function deleteProfileWarning(){
    $(document).on("click","#deleteMessage", function() {
        $(".modal-bg").css("visibility", "visible");   
        $(".nes").css("visibility", "visible"); 


        $(document).on('click','#deleteProfile',function(e){
            e.preventDefault()
            var id=$(this).data('iddelete')
            var data={
                "id":id
            }
            ajax2('models/profile-delete.php','post',data,function(result){
                window.location.href=result.location
            })
        })
        
    })
    $(document).on("click","#closeModal", function(){
        $(".nes").css("visibility", "hidden"); 
        $(".modal-bg").css("visibility", "hidden");
    })
}

$(document).ready(function(){
    $('#icon').click(function(){
        $('ul').toggleClass('show')
    })
})


function approvedAd(){
    $(document).on('click','.ad-approve',function(e){
        e.preventDefault()
        var id=$(this).data('adrequest')
        var data={
            "id":id
        }
        
        ajax2('models/approved-ad.php','post',data,function(result){
            printSuccess(result);
        })
    })
}

function printSuccess(message){

    var divConfirm=document.querySelector('#messageSuccess')
    if(divConfirm){
        divConfirm.classList.remove('confirmAd2')
        divConfirm.classList.add('confirmAd')
        let html=`${message.message}`
        divConfirm.innerHTML=html
    }
}

function printAdList(array){
    let html=''
    if(array.length!=0){
        for(let x of array){
            html+=`<tr class="red">
            <td>${x.naziv}</td>
            <td>${x.ime + " " + x.prezime}</td>
            <td class="text-right">${x.datum_postavljanja}</td>
            <td class="text-center"><a class="btn-potvrdiNek" href="/propertie-page.php?idProp=${x.id_nekretnine}" id="realEstate" data-id="${x.id_nekretnine}"><i class="fa fa-eye"></i></a></td>
            <td class="text-center"><a class="btn-obrisi adDelete" href="#" data-addelete="${x.id_nekretnine}"><i class="fa fa-trash"></a></td>
            `
        }
     }
     else{
         html+='<h4 class="text-center">Trenutno nema aktivnih oglasa.</h4>'
     }
  
     document.querySelector('#adFullList').innerHTML=html
}


function requestForActiveOrDeleteAgent(className,dataName,url,functionName){

    $(document).on('click',className,function(e){
        var id=$(this).data(dataName)
        var data={
            "id":id
        }
        console.log(id)
        ajax2(url,'post',data,function(result){
            functionName(result);
        })
    })
}

function printMessage(array){
    let html=''
    if(array.length!=0){
       for(let x of array){
           html+=`<tr class="red">
           <td>${x.ime + " " + x.prezime}</td>
           <td>${x.naslov}</td>
           <td>${x.mail_adresa}</td>
           ${readOrUnreadMessage(x.procitano,x.id_poruke)}
           <td class="text-center"><a class="btn-obrisiNek deleteMessage" href="#" data-message="${x.id_poruke}"><i class="fa fa-trash"></a></td>`
       }
    }
    else{
        html+='<h4 class="text-center">Trenutno nema poruka.</h4>'
    }
 
    document.querySelector('#mesagesTable').innerHTML=html
}


function readOrUnreadMessage(readValue,idMessage){
    html=''
    if(readValue) html+=`<td>Pročitana</td>
    <td class="text-center"><a class="btn-potvrdiNek" href="/admin-page/message-page.php?id=${idMessage}"><i class="fa fa-check-circle"></i></a></td>`
    else html+=`<td>Nepročitana</td>
    <td class="text-center"><a class="btn-potvrdiNek3" href="/admin-page/message-page.php?id=${idMessage}"><i class="fa fa-eye"></i></a></td>`

    return html
}

function printAllUsers(array){
    let html=''
    if(array.length!=0){
       for(let x of array){
           html+=`<tr class="red">
           <td>${x.ime + " " + x.prezime}</td>
           <td>${x.id_korisnik}</td>
           <td>${x.mail_adresa}</td>
           <td class="text-right">${x.datum_kreiranja_profila}</td>
           <td class="text-right">${x.naziv_uloga}</td>
           <td class="text-center"><a class="btn-obrisi deleteUser" href="#" data-userdelete="${x.id_korisnik}"><i class="fa fa-trash"></a></td>
           </tr>`
       }
    }
    else{
        html+='<h4 class="text-center">Trenutno nema registrovanih profila.</h4>'
    }
 
    document.querySelector('#allUsers').innerHTML=html
}

function printAgentsList(array){
    let html=''
   if(array.length!=0){
      for(let x of array){
          html+=`<tr class="red">
          <td>${x.ime + " " + x.prezime}</td>
          <td>${x.id_agent}</td>
          <td>${x.mail_adresa}</td>
          <td class="text-right">${x.datum_kreiranja_profila}</td>
          <td class="text-right">${x.broj_dozvole}</td>
          <td class="text-center"><a class="btn-obrisi agentDelete" href="#" data-idagent="${x.id_agent}"><i class="fa fa-trash"></a></td>
          </tr>`
      }
   }
   else{
       html+='<h4 class="text-center">Trenutno nema aktivnih agent profila.</h4>'
   }

   document.querySelector('#agent').innerHTML=html
}

function printRequest(array){
   let html=''
   if(array.length!=0){
      for(let x of array){
          html+=`<tr class="red">
          <td>${x.ime + " " + x.prezime}</td>
          <td>${x.broj_dozvole}</td>
          <td>${x.mail_adresa}</td>
          <td class="text-right">${x.datum_zahteva}</td>
          <td class="text-center"><a class="btn-potvrdiNek agentApprove" href="#" data-idapprove="${x.id_agent}"><i class="fa fa-check-circle"></i></a></td>
          <td class="text-center"><a class="btn-obrisi agentRequestDelete" href="#" data-agentreqdelete="${x.id_agent}"><i class="fa fa-trash"></a></td>
          </tr>`
      }
   }
   else{
       html+='<h4 class="text-center">Trenutno nema vise zahteva za aktivaciju.</h4>'
   }

   document.querySelector('#requestAgent').innerHTML=html
}



function printAdListRequest(array){
    let html=''
    if(array.length!=0){
      for(let x of array){
          html+=`<tr class="red">
          <td>${x.id_nekretnine}</td>
          <td>${x.naziv}</td>
          <td>${x.ime + " " + x.prezime}</td>
          <td class="text-right">${x.datum_postavljanja}</td>
          <td class="text-center"><a class="btn-potvrdiNek" href="/propertie-page.php?idProp=${x.id_nekretnine}"><i class="fa fa-eye"></i></a></td>
          <td class="text-center"><a class="btn-obrisiNek deleteReqAd" href="#" data-deleteadreq="${x.id_nekretnine}"><i class="fa fa-trash"></a></td>
          </tr>`
      }
   }
   else{
       html+='<h4 class="text-center">Trenutno nema vise zahteva za aktivaciju.</h4>'
   }

   document.querySelector('#adReq').innerHTML=html
}


function newslatterForm(){
    const email=document.querySelector('#email')
    const form=document.querySelector('#formaNewslatter')

    const emailReg=/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/

    listenerField(email,'blur',emailReg)
    
    
    form.addEventListener('submit',function(e){
        if(!submitBtn()){
            e.preventDefault()
            validationField(email,emailReg)
        }else{
        }
    })

    function submitBtn(){
        if(
            validationField(email,emailReg) 
        ){
            return 1
        }else{
            return 0
        }
    }

    document.querySelector('#send',submitBtn)

}

function registerForm(){
    const firstName=document.querySelector('#first-name')
    const lastName=document.querySelector('#last-name')
    const username=document.querySelector('#username')
    const password=document.querySelector('#password')
    const email=document.querySelector('#mail')
    const repeatPswd=document.querySelector('#repeat-password')
    const form=document.querySelector('#registration-form')

    const firstNameRegex =  /^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{2,14}$/
    const lastNameRegex = /^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{4,29}$/
    const passwordRegex = /^[A-Z]{1}[a-z0-9!@#$%^.&*]{7,19}$/   
    const userMailRegex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/
    const userNameRegex = /^([a-z]{1})[a-z0-9]{4,29}$/

    form.addEventListener('submit',function(e){
        if(!submitBtn()){
            e.preventDefault()
            validationField(firstName,firstNameRegex)
            validationField(lastName,lastNameRegex) 
            validationField(username,userNameRegex) 
            validationField(password,passwordRegex) 
            validationField(email,userMailRegex) 
            validationRepeatPassword()
        }else{
            console.log('poslao')
        }
    })

    document.querySelector('#btn-reg',submitBtn)

    listenerField(firstName,'blur',firstNameRegex)
    listenerField(lastName,'blur',lastNameRegex)
    listenerField(username,'blur',userNameRegex)
    listenerField(password,'blur',passwordRegex)
    listenerField(email,'blur',userMailRegex)


    function submitBtn(){
        if(
            validationField(firstName,firstNameRegex) &&
            validationField(lastName,lastNameRegex) &&
            validationField(username,userNameRegex) &&
            validationField(password,passwordRegex) &&
            validationField(email,userMailRegex) &&
            validationRepeatPassword()
        ){
            return 1
        }else{
            return 0
        }
    }

    function validationRepeatPassword(){
        if(password.value==repeatPswd.value){
            repeatPswd.nextElementSibling.classList.add('hidden')
            return 1
        }else{
            repeatPswd.nextElementSibling.classList.remove('hidden')
            return 0
        }
    }
    repeatPswd.addEventListener('blur',validationRepeatPassword)
  
}

function logInForm(){
    const username=document.querySelector('#username-login')
    const password=document.querySelector('#password-login')
    const form=document.querySelector('#login-form')

    const userNameRegex = /^([a-z]{1})[a-z0-9]{4,29}$/
    const passwordRegex = /^[A-Z]{1}[a-z0-9!@#$%^.&*]{7,19}$/ 

    form.addEventListener('submit',function(e){
        if(!submitBtn()){
            e.preventDefault()
            validationField(username,userNameRegex)
            validationField(password,passwordRegex) 
        }else{
            console.log('poslao')
        }
    })

    function submitBtn(){
        if(
            validationField(username,userNameRegex) &&
            validationField(password,passwordRegex) 
        ){
            return 1
        }else{
            return 0
        }
    }

    document.querySelector('#btn-log',submitBtn)

    listenerField(username,'blur',userNameRegex)
    listenerField(password,'blur',passwordRegex)
}

function agentForm(){
    

    const licence=document.querySelector('#licence')
    const phone=document.querySelector('#phone')
    const form=document.querySelector('#agent-form')

    const licenceReg = /^[\d]{13}$/
    const phoneReg = /^06[\d]{7,8}$/

    form.addEventListener('submit',function(e){
        if(!submitBtn()){
            e.preventDefault()
            validationField(licence,licenceReg) &&
            validationField(phone,phoneReg) 
        }else{
            console.log('poslao')
        }
    })

    function submitBtn(){
        if(
            validationField(licence,licenceReg) &&
            validationField(phone,phoneReg) 
        ){
            return 1
        }else{
            return 0
        }
    }
    document.querySelector('#btn-agent-reg',submitBtn)
    
    listenerField(licence,'blur',licenceReg)
    listenerField(phone,'blur',phoneReg)
}

function updateProfileForm(){
    const firstNameUpdate=document.querySelector('#update-first-name')
    const lastNameUpdate=document.querySelector('#update-last-name')
    const usernameUpdate=document.querySelector('#update-username')
    const emailUpdate=document.querySelector('#update-mail')
    const updateForm=document.querySelector('#update-profile-form')


    const firstNameRegex =  /^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{2,14}$/
    const lastNameRegex = /^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{4,29}$/
    const userMailRegex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/
    const userNameRegex = /^([a-z]{1})[a-z0-9]{4,29}$/

    listenerField(firstNameUpdate,'blur',firstNameRegex)
    listenerField(lastNameUpdate,'blur',lastNameRegex)
    listenerField(usernameUpdate,'blur',userNameRegex)
    listenerField(emailUpdate,'blur',userMailRegex)

    updateForm.addEventListener('submit',function(e){
        if(!submitBtn()){
            e.preventDefault()
            validationField(firstNameUpdate,firstNameRegex)
            validationField(lastNameUpdate,lastNameRegex) 
            validationField(usernameUpdate,userNameRegex) 
            validationField(emailUpdate,userMailRegex) 
        }else{
           
        }
    })

    function submitBtn(){
        if(
            validationField(firstNameUpdate,firstNameRegex) &&
            validationField(lastNameUpdate,lastNameRegex) &&
            validationField(usernameUpdate,userNameRegex) &&
            validationField(emailUpdate,userMailRegex) &&
            validationRepeatPassword()
        ){
            return 1
        }else{
            return 0
        }
    }


}

function scheduleValidation(){
    var scheduleDll=document.querySelector('#schedule-ddl')
    var dateSchedule=document.querySelector('#dateSchedule')
    if(scheduleDll && dateSchedule){
        const scheduleDll=document.querySelector('#schedule-ddl')
        const dateSchedule=document.querySelector('#dateSchedule')
        const agent=document.querySelector('#agent')
        const user=document.querySelector('#user')
        const propertie=document.querySelector('#propertie')
        var error
        const form=document.querySelector('#schedule-form')
        const dateNow=new Date()

        var currentlyTime=dateNow.getTime()

   
        function dateValidation(){
        var pickDate=dateSchedule.value
        var year=pickDate.substring(0,4)
        var month=pickDate.substring(5,7)-1
        var day=pickDate.substring(8,pickDate.length)
        var objDate=new Date(year,month,day)
        var pickDateMiliseconds=objDate.getTime()
       

        if(currentlyTime > pickDateMiliseconds){
            dateSchedule.nextElementSibling.classList.remove('hidden')
            return 0
        }else{
            dateSchedule.nextElementSibling.classList.add('hidden')
            return 1
        }
    }

    dateSchedule.addEventListener('blur',function(){
        var pickDate=dateSchedule.value
        var year=pickDate.substring(0,4)
        var month=pickDate.substring(5,7)-1
        var day=pickDate.substring(8,pickDate.length)
        var objDate=new Date(year,month,day)
        var pickDateMiliseconds=objDate.getTime()
       

        if(currentlyTime > pickDateMiliseconds){
            dateSchedule.nextElementSibling.classList.remove('hidden')
        }else{
            dateSchedule.nextElementSibling.classList.add('hidden')
        }
    })

    listenerDdl(scheduleDll,'blur')

    form.addEventListener('submit',function(e){
        if(!submitBtn()){
            e.preventDefault()
            validationDdl(scheduleDll)
            dateValidation()
        }else{
            
        }
    })

    

    function submitBtn(){
        if(
            validationDdl(scheduleDll) &&
            dateValidation()
        ){
            return 1
        }else{
            return 0
        }
    }
    }
    
}

var tip=""
function specValidation(nizEl){
    
        for (let i = 0; i < nizEl.length; i++) {
            var znak=document.getElementById(nizEl[i].getAttribute('id'))
            znak.nextElementSibling.classList.add('hidden')
        }
    var nizObj = [];
    let nizSpecObj = [
        {
            karakteristika: "povrsina",
            niz: [2,3,8,17,22],
            izraz: /^[\d]{1,5}$/,
            vrednosti: null,
            poruka: "Neispravan format unosa, broj mora pripadati opsegu [0,10000]."
        },
        {
            karakteristika: "broj",
            niz: [1,4,5,7,10,24],
            izraz: /^[\d]{1,2}$/,
            vrednosti: null,
            poruka: "Neispravan format unosa, broj mora pripadati opsegu [0,99]."
        },
        {
            karakteristika: "opremljenost",
            niz: [9],
            izraz: null,
            vrednosti: ['opremljeno','poluopremnljeno','neopremljeno'],
            poruka:"Neispravan format unosa, moguće vrednosti su: (1) opremljeno, (2) poluopremnljeno i (3) neopremljeno."
        },
        {
            karakteristika: "stanje",
            niz: [11],
            izraz: null,
            vrednosti: ['novogradnja','starogradnja'],
            poruka: "Neispravan format unosa, moguće vrednosti su: (1) novogradnja i (2) starogradnja."
        },
        {
            karakteristika: "potvrda",
            niz: [6,12,13,14,15,16,21,23,25],
            izraz: null,
            vrednosti: ['da','ne'],
            poruka: "Neispravan format unosa, moguće vrednosti su: (1) da i (2) ne."
        },
        {
            karakteristika: "tipZemljista",
            niz: [18,19],
            izraz: null,
            vrednosti: ['gradjevinsko','poljoprivredno'],
            poruka: "Neispravan format unosa, moguće vrednosti su: (1) građevinsko i (2) poljoprivredno."
        },
        {
            karakteristika: "prostorije",
            niz: [20],
            izraz: null,
            vrednosti: ['kupatilo','kuhinja'],
            poruka: "Neispravan format unosa, moguće vrednosti su: (1) kuhinja i (2) kupatilo."
        }
    ]
    var i=0
    while (i < nizEl.length){
        var rez=false
        let el = nizSpecObj.find(x => x.niz.includes(parseInt(nizEl[i].getAttribute('name'))));
        if (el.vrednosti != null && el.izraz == null) {
            for (let vrednost of el.vrednosti) {
                if (nizEl[i].value.toLowerCase() == vrednost){
                    rez = true;
                break;
                }
            }
    }

    if (el.vrednosti == null && el.izraz != null) {
        if (el.izraz.test(nizEl[i].value.toLowerCase())){
            rez = true
        }
    }


    nizObj.push({
        ispravno: rez,
        specId: nizEl[i].name,
        poruka: el.poruka,
        vrednost: nizEl[i].value.toLowerCase(),
        karakteristika: el.karakteristika
        })
    i++


}
    return nizObj;
}


function validationInsertPropertie(){
    var propertieName=document.querySelector('#propertie-name')
    var propertieCity=document.querySelector('#ddl-city')
    var propertieTransaction=document.querySelector('#ddl-transaction-type')
    var propertieType=document.querySelector('#ddl-type')
    var price=document.querySelector('#price')
    var description=document.querySelector('#description')
    var btnConfirm=document.querySelector('#btn-confirm-propertie')
    var agentId=document.querySelector('#agent-id');
    
    var priceRegEx=/^[\d]{1,10}$/
    var descriptionRegEx=/^[\w\s]{5,1000}$/
    var propertieNameRegEx=/[\w\s]{5,50}/
    
    listenerField(propertieName,'blur',propertieNameRegEx)
    listenerField(price,'blur',priceRegEx)
    //listenerField(description,'blur',descriptionRegEx)
    listenerDdl(propertieCity,'blur')
    listenerDdl(propertieType,'blur')
    listenerDdl(propertieTransaction,'blur')

    btnConfirm.addEventListener('click',function(){
        if(!submitBtn()){
            validationField(propertieName,propertieNameRegEx)
            validationField(price,priceRegEx) 
            //validationField(description,descriptionRegEx)  
            validationDdl(propertieCity) 
            validationDdl(propertieType) 
            validationDdl(propertieTransaction)
        }
    })

    var objSlanje={}
    

    function submitBtn(){
        console.log(objSlanje)
        let nizSpecifikacija = document.querySelectorAll(`div[data-tip = "${tip}"] input`);
	    let nizObj = specValidation(nizSpecifikacija)
	    let br = 0;
	    for (let i = 0; i < nizObj.length; i++) {
            $(`p[data-id = "${nizObj[i].specId}"]`).removeClass("hidden")
            var pTag=$(`p[ data-id = "${nizObj[i].specId}"]`)
		    if (!nizObj[i].ispravno) {
			    br++;
                pTag.html(nizObj[i].poruka)
                pTag.css("color", "rgb(244,78,78)")
                pTag.css("font-size", "12px")
                pTag.css("font-weight", "bold")

		    }
            else{
                pTag.html("Ispravan format")
                pTag.css("color", "#25e26a")
                pTag.css("font-size", "12px")
                pTag.css("font-weight", "bold")
            }
	    }
        


        if (validationField(propertieName,propertieNameRegEx) &&
            validationField(price,priceRegEx)  &&
           // validationField(description,descriptionRegEx)  &&
            validationDdl(propertieCity) &&
            validationDdl(propertieType) &&
            validationDdl(propertieTransaction) &&
            br == 0 && (tip=tip))
            {
                let obj= {
                    "propertieName": propertieName.value,
                    "city": propertieCity.value,
                    "transaction": propertieTransaction.value,
                    "type": propertieType.value,
                    "price":price.value,
                    "description":description.value,
                    "agent":agentId.value,
                    "btn": true
                };
                
                let nizPre=[]

                for(let i=0;i<nizObj.length;i++){
                    nizPre.push({
                        "id": nizObj[i].specId, 
                        "vrednost": nizObj[i].vrednost,
                        "karakteristika":nizObj[i].karakteristika
                    });   
                }
                
                objSlanje = Object.assign(objSlanje, obj);
                objSlanje["specifikacije"] = nizPre

             $.ajax({
                url: "models/properties-validation.php",
                method: "post",
                data:objSlanje,
                dataType: "json",
                success: function(result){
                    window.location.href=result.lokacija
                },
                error: function(xhr){
                    console.log(xhr)
                }
            })
                
                return 1
                
            }
        else{
            return 0
        }
    }



    propertieType.addEventListener('change',function(){
        var id=propertieType.value
        
        tip=id
        ajaxCallBack("models/get-specification.php","post",id,printSpecificationInput)
    })

}

function printSpecificationInput(array){
    let html='<h4 class="text-right mb-3">Specifikacije</h4>'
    if(!array.length){
        html+='<p>Nije izabran tip nekretnine</p>';
    }else{
        for(let spec of array){
            html+=`<div class="col-md-12" data-tip="${spec.id_tip}">
            <label class="labels">${spec.naziv_specifikacija}</label>
            <input type="text" class="form-control" name="${spec.id_specifikacija}" id="${spec.naziv_specifikacija}"/>
            <p class="mb-3" data-id="${spec.id_specifikacija}"></p>
          </div>`
        }
    }
    document.querySelector('#specifications').innerHTML=html;
}

function paginationRealEstates(){
    $(document).on('click','.pagination',function(e){
        e.preventDefault()

        let limit=$(this).data('limit');
        let data={
            "limit":limit
        }

        ajax2('models/pagination.php','post',data,function(result){
            printRealEstates(result.realEstate)
            printPagination(result.pages)
        })
        
    })
}


function ajax2(url, method, data, result) {
    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: "json",
        success: result,
        error: function(xhr){
            console.error(xhr);
        }
    })
}

function filter(){
    var objekatZaSlanje = null

$(".filterTag > input").on("change", function() {
    if ($(".filterTag > input:checked").length > 0) {
        objekatZaSlanje = {
            "grad": [],
            "struktura": [],
            "tip": [],
            "prazan":false
        }
        $(".filterTag > input:checked").each(function(el) {
            objekatZaSlanje[$(this).attr("name")].push(parseInt($(this).val()));
        });
    }
    else objekatZaSlanje = {
        "prazan": true
    }

    console.log(objekatZaSlanje)
    ajax2("models/pagination.php", "POST", objekatZaSlanje, function(result) {
        printRealEstates(result.realEstate)
        printPagination(result.pages)
    });
});
$(`input[name = "btn-filter"]`).on("click", function() {
    $('.filterTag > input:checkbox').removeAttr('checked');
    objekatZaSlanje = null
});


}




function setPictureForPagination(path){
    var path=path
    $.ajax({ 
        url: path, 
        method: "post", 
        dataType: "json", 
        success:function(result){ 
            skladistiLS('slike2',result); 
        }, 
        error: function(xhr) {
            console.log(xhr)
        }
    })
}



function printRealEstates(array){
    let html=''
    
    if(array.length==0){
        html+='<h4>Trenutno nema oglasa</h4>'
    }
    else{
        for(let element of array){
            html+=` <div class="cart-properties">
            <div class=" img-cart">
                ${printPicture2(element.id_nekretnine)} 
            </div>
            <div class="body-cart">
                <h3><a href="propertie-page.php?idProp=${element.id_nekretnine}" id="realEstate" data-id="${element.id_nekretnine}">${element.naziv}</a></h3>
                <p>${element.naziv_grad}</p>
                <h4>${element.cena + ",00 EUR"}</h4>
            </div>
        </div>`
        }

        html+=`<div class="number">
            <ul class="page-number" id="paginacija">
            </ul>
        </div>`
    }
    document.querySelector('#realEstates').innerHTML=html
   
}

function printPicture2(id){
    var pictures=vratiLS('slike2')
    let html='<img src="assets/img/no img.png">'
    for(let pic of pictures){
        if(id==pic.id_nekretnine){
            html=`<img src="${pic.slika_putanja}">`;
            break
        }
    }
    return html
}




function printPagination(brojStranica){
            html = "";
    
            for(let i = 0; i < brojStranica; i++){
            html += `<span><li><a class="pagination" data-limit="${i}" href="">${i+1}</a></li></span>`
            }
    
    
            $("#paginacija").html(html);
        
} 


function contactValidation(){
    const firstName=document.querySelector('#firstName')
    const lastName=document.querySelector('#lastName')
    const headline=document.querySelector('#headline')
    const message=document.querySelector('#message')
    const form=document.querySelector('#contactForm')

    const firstNameRegex =  /^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{2,14}$/
    const lastNameRegex = /^[A-ZČĆŽŠĐ]{1}[a-zčćžšđ]{4,29}$/ 
    const headLineReg=/^[\w\d\s?!*]{1,255}$/  
    const messageReg=/^[\w\d\s]{1,999}$/  
    listenerField(firstName,'blur',firstNameRegex)
    listenerField(lastName,'blur',lastNameRegex)
    listenerField(headline,'blur',headLineReg)
    //listenerField(message,'blur',messageReg)

    form.addEventListener('submit',function(e){
        if(!submitBtn()){
            e.preventDefault()
            validationField(firstName,firstNameRegex)
            validationField(lastName,lastNameRegex) 
            validationField(headline,headLineReg) 
        }else{
            console.log('poslao')
        }
    })

    document.querySelector('#btnCont').addEventListener('click',submitBtn)

    function submitBtn(){
        if(
            validationField(firstName,firstNameRegex) &&
            validationField(lastName,lastNameRegex)  &&
            validationField(headline,headLineReg)  
        ){
            return 1
        }else{
            return 0
        }
    }
}




function listenerField(field,event,regEx){
    field.addEventListener(event,function(){
        validationField(field,regEx)
    })
}

function listenerDdl(field,event){
    field.addEventListener(event,function(){
        validationDdl(field)
    })
}
function validationDdl(tagOpt){
    if(tagOpt.value==""){
        tagOpt.nextElementSibling.classList.remove('hidden')
        return 0
    }
    else{
        tagOpt.nextElementSibling.classList.add('hidden')
        return 1
    }
}

function validationField(id,reg){
    if(reg.test(id.value)){
        id.nextElementSibling.classList.add('hidden')
        return 1
    }
    else if(id.value==""){
        id.nextElementSibling.classList.remove('hidden')
        return 0
    }
    else{
        id.nextElementSibling.classList.remove('hidden')
        return 0
    }
}



function getPicturesFromOneAd(){
    $(document).on('click','#realEstate',function(){
        var id=$(this).data('id')  
        ajaxCallBack("models/get-pictures.php","post",id,function(result){
            skladistiLS("slike",result)
        })
    })
}

function getPicturesForAdmin(){
    
    $(document).on('click','#realEstate',function(){
        var id=$(this).data('id')    
        ajaxCallBack("../models/get-pictures.php","post",id,function(result){
            skladistiLS("slike",result)
        })
    })
}

function printPicture(){
    var slike=vratiLS('slike')
    let html="<div class='carousel-inner position-relative'>"
    if(slike.length!=0){
        for(let i=0;i<slike.length;i++){
            html+=` <div class="carousel-item slide active ${slike.length>1 ? "d-none" : "" }">
                        <img class="d-block " src="${slike[i].slika_putanja}" alt="First slide">
            </div>` 
        }
    }
    else{
        html+=`<div class="row bg-pic2" style="background-image: url('assets/img/noimg.jpg');">
        </div>`
    }
    html+='</div>'

    if(slike.length>1){
        html+=`
        <a class="carousel-control-prev c-control" id="previous" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next c-control" id="next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>`
    }
    $(document).on('click','.c-control',function(e){
        e.preventDefault()
        moveSlide($(this).attr('id'));
    })


    document.querySelector('#carouselExampleIndicators').innerHTML=html

    if(slike.length>1){
        $(document).ready(function() { 
            $(".slide:first-of-type").removeClass("d-none"); 
        
            var timer;
            window.addEventListener("load", function() {
                timer = setInterval(function() {
                    moveSlide("next");
                }, 7000);
            });
        
            $(".slide").hover(function() {
                clearInterval(timer);
            }, function() {
                timer = setInterval(function() {
                    moveSlide("next");
                }, 7000);
            });
        });
    }
}



function skladistiLS(naziv,data){ 
    localStorage.setItem(naziv,JSON.stringify(data)) 
} 
function vratiLS(name){ 
    return JSON.parse(localStorage.getItem(name)) 
   } 
function obrisiLS(naziv){ 
    localStorage.removeItem(naziv) 
}


function ajaxCallBack(url,method,id,callBack){
    $.ajax({
        url: url,
        method: method,
        data: {
            id: id
        },
        dataType: "json",
        success: function(result){
            callBack(result)
        },
        error: function(xhr){
            console.error(xhr);
        }
    })
}


var slideIndex = 0;
let slides = document.getElementsByClassName("slide");
function moveSlide(direction) {
    slides[slideIndex].classList.add("d-none");

    if (direction == "next") {
        slideIndex++;
        if (slideIndex == slides.length) 
            slideIndex = 0;
    } 
    else {
        if (slideIndex == 0) 
            slideIndex = slides.length - 1;
        else slideIndex--;
    }

    slides[slideIndex].classList.remove("d-none");
}
