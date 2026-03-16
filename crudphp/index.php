<h2>Add E-Resource</h2>
 
<form method="post" action="create.php">
    Title: <input type="text" name="title" required><br>
    Resource Type:
    <select name="resource_type" required>
        <option value="">-- Select --</option>
        <option value="eJournal">eJournal</option>
        <option value="eBook">eBook</option>
        <option value="Database">Database</option>
        <option value="Multimedia">Multimedia</option>
        <option value="Research Tool">Research Tool</option>
    </select><br>
    Stock: <input type="number" name="stock" min="0" required><br>
    <button type="submit">Save</button>
</form>
 
<a href="read.php">View E-Resources</a>
 