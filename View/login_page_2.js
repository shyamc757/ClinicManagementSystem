function login() {
    // send request
    // login as user
    // establish DB connection
    // open a home page
    if(document.getElementById("Password").value == "admin" && document.getElementById("Username").value == "admin" ) {
    window.open("./HomePageModule/AdminHomePage.html", "_self");
    }
    else if(document.getElementById("Password").value == "recp" && document.getElementById("Username").value == "recp" ) {
        window.open("./HomePageModule/ReceptionHomePage.html", "_self");
    }
    else if(document.getElementById("Password").value == "invm" && document.getElementById("Username").value == "invm" ) {
        window.open("./HomePageModule/InventoryHomePage.html", "_self");
    }
    else{
        alert("Wrong login creds")
    }
}