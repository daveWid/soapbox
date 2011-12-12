<div id="search">
	<form action="<?php echo Route::url('soapbox/action', array('action' => "search")); ?>" method="" id="search-form">
		<label for="search">Search</label>
		<input type="search" name="query" value="<?php echo Request::current()->query('query'); ?>" id="search" />

		<input type="submit" value="Search" />
	</form>
</div>