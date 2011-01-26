<html><head><title>DORY CMS - CRUD Tests</title></head><body>

<h2>Case 0</h2>
<p>Pre-Populating the User Roles. Values are hard coded. Admin and Mod</p>
<a href="unittest.php?test=0">Run</a>

<hr>

<h2>Case 1</h2>
<p>Creating a new User (multiple users can've same email IDS + same usernames)</p>
<form method="GET" action="unittest.php">
	Email: <input type="text" name="email" /> <br />
	Username:<input type="text" name="uname" />
	Password: <input type="password" name="password" />
	<input type="hidden" name="test" value="1" />
	<input type="submit" value="Register" />
</form>

<hr>

<h2>Case 1.1</h2>
<p>Creating a new User (every user must've unique email IDS + unique usernames)</p>
<form method="GET" action="unittest.php">
	Email: <input type="text" name="email" /> <br />
	Username:<input type="text" name="uname" />
	Password: <input type="password" name="password" />
	<input type="hidden" name="test" value="11" />
	<input type="submit" value="Register" />
</form>

<hr>

<h2>Case 2</h2>
<p>Existing user with a new Post</p>
<form method="GET" action="unittest.php">
<input type="hidden" name="test" value="2" />
Email: <input type="text" name="email" /> <br />
Title: <input type="text" name="title" />
<input type="submit" value="Publish Post" />
</form>

<hr>


<h2>Case 3</h2>
<p>Get user's Posts</p>
<form method="GET" action="unittest.php">
<input type="hidden" name="test" value="3" />
Email: <input type="text" name="email" /> <br />
<input type="submit" value="Get Posts" />
</form>

<hr>


<h2>Case 4</h2>
<p>Existing user with a new Post + Comment</p>
<form method="GET" action="unittest.php">
<input type="hidden" name="test" value="4" />
Email: <input type="text" name="email" /> <br />
Title: <input type="text" name="title" />
<textarea name="comment">Your Comment here</textarea>
<input type="submit" value="Publish Post" />
</form>

<hr>


<h2>Case 5</h2>
<p>Pre-Populating some Default Category (Doesn't check for duplicates)</p>
<a href="unittest.php?test=5">Run</a>
<h4>Adding a custom Category</h4>
<form method="GET" action="unittest.php">
<input type="hidden" name="test" value="5" />
<input type="hidden" name="custom" value="1" />
Category: <input type="text" name="cat" /> <br />
<input type="submit" value="Add Category" />
</form>

<hr>


<h2>Case 6</h2>
<p>Existing user with a new Post + Category (If already exist, uses that, else creates a new one)</p>
<form method="GET" action="unittest.php">
<input type="hidden" name="test" value="6" />
Email: <input type="text" name="email" /> <br />
Title: <input type="text" name="title" /> <br />
Category: <input type="text" name="cat" /> <br />
<textarea name="comment">Your Comment here</textarea>
<input type="submit" value="Publish Post + Category" />
</form>


</body>
</html>
