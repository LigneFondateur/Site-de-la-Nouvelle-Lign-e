<style>
.contact {
    width: 400px;
    height: 100px;
    resize: none;
    border-radius: 5px;
    font-size: 16px;
    padding: 5px;
    outline: none;
    border: 2px solid black;
    background-color: #eee;
    color: #000;
</style>
<section >

<center>
    <h1>Support et Assistance</h1>
    <p>Besoin d'aide ? Contactez notre équipe de support !</p>
    
    <!-- Formulaire de contact -->
    <form action="traitement_contact.php" method="post">
        <p>Nom :</p>
        <input type="text" id="nom" name="nom" required><br><br>
        
        <p>E-mail :</p>
        <input type="email" id="email" name="email" required><br><br>
        
        <p>Message :</p><br>
        <textarea id="message" name="message" rows="4" cols="50" required class="contact"></textarea><br><br>
        
        <input type="submit" value="Envoyer">
    </form>
</center>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>