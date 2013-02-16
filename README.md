# I Feel PreTTY
I Feel PreTTY is a package for formatting PHP scripts on ANSI
terminals. Script output is often going by too fast to read, or has
too little information to be useful. There is often no indication of
how long until done. Adding colors and grouped indentation and an
estimated time to completion leaves you that much more prepared for
those late nights running those unnerving migrations

distributed under the MIT license.

## What you get right away
1. Automatic indent management with tier grouping
2. ANSI colors (teal, yellow, white, grey, purple), bold
3. Progress bar - 0% to 100%
4. Estimated time to completion - minutes seconds
5. Increased saliva production during sexy script readouts
6. Automatically resizes with your terminal
7. Simple, chainable, and object oriented API

![Preview of PreTTY output](http://wikifightgame.com/moarcontent/I-Feel-PreTTY.png)

# Using it in three steps

1. Create a class that extends PreTTYProcess, and `->install()` your
components. You can start without any installed components by passing
`array()` as the first constructor parameter.

	class ExampleMigration extends PreTTYProcess {

		function __construct() {
			parent::__construct();
			$this->install(new PreTTYBreadCrumbs);
		}

		function run() {
			//...
		}
	}

2. Count your operations as best you can. This will be used to track
completion percentage and time estimates

	function run() {
		$this->setTasks(UserQuery::create()->count());

		foreach(UserQuery::create()->find() as $user) {
			$this->doSomethingWith($user);
		}
	}

3. Perform each task, marking them complete along the way. This part
is your job, not mine!

	function doSomethingWith(User $user) {
		$this->say('Processing user #' . $user->getUserID(), 'blue')
			->indent()
			->say('Doing first thing');

		$user->doSomething();

		$this->say('Saving');

		$user->save();

		$this->say('done', 'green')
			->outdent()
			->completeTask();
	}

# Documentation

## PreTTYDemo:
Have a nice serenading demo of PreTTYProcess, just run `php demo.php`
to see what the PreTTYDemo object has in store for you.

## PreTTYProcess:
PreTTYProcess is in itself a very basic object. What it allows is
installing components. The standard PreTTYFormatter and the
PreTTYProgressBar are installed by default. It then uses `__call()`
to send data as hooks all the installed components. Data returned
during a hook is printed. And yes, you can write your own components,
quite easily.

### Main methods:
* `__construct(array $components)`
> If you do not provide any components PreTTYFormatter and
> PreTTYProgressBar are installed by default. Technically the next two
> arguments accept a PreTTYColorCodeProvider and a TPUTWrapper. These
> classes create themselves if you do not have a reason to provide them.

* `->say(string $text, string $color = 'grey', boolean $is_bold = false)`
> Available colors are teal, yellow, white, grey, and purple. They will
> not necessarily appear that color on a terminal since most terminals
> let you customize them. If your output is not indented, bold actually
> defaults to true.

* `->install(iPreTTYComponent $component)`
> Install a new component. PreTTYFormatter and PreTTYProgress bar are
> installed by default. PreTTYBreadCrumbs ships but is not installed by
> default. You can write and install your own components.

* `->runHook($hook, array $data = array())`
> Manually run a hook. Every component will receive the hook and the
> data, and either handle it or ignore it. Hooks are run in the order
> that components were installed.

## Available Components

### PreTTYFormatter
This is the standard indentation/truncation formatter. But you can easily
swap it out with your own. Installed by default

#### Methods given to PreTTYProcess after installation
* `->indent()`
> Indent the following calls of `->say()`

* `->outdent()`
> de-Indent the following calls of `->say()`

### PreTTYProgressBar
This renders a progress bar and estimated time until completion at the
bottom of your terminal

#### Methods given to PreTTYProcess after installation
* `->setTasks(integer $amount)`
> progress bar and time estimate is generated by comparing the amount
> provide here to how many times you've called `->completeTask()`

* `->completeTasks()`
> The progress bar and time estimate is generated by tracking how many
> tasks you've marked completed with this function, to how many total
> tasks you set with `->setTasks()`

### PreTTYBreadCrumbs
The top of your terminal will track the breadcrumbs of how your process
arrived at its latest output. For instance, if every A is compared to
every B, and merged together an item at a time, then you may see this:

	+Begin comparing A #123 to all Bs
	+++Comparing to B #194
	+++++Consolidating
	+++++++Consolidating first items

#### Methods given to PreTTYProcess after installation
none

## Creating a component
Your components must implement the interface iPreTTYComponent. There
are three methods you must meet:

* `->setWidth($v)`
> Tells your component the terminal width (in columns). This is called
> regularly at the moment. In the future it will only be called when it
> changes.

* `->setEncoder(PreTTYColorEncoder $encoder)`
> See the PreTTYColorEncoder's documentation for using colors and moving
> the cursor

* `->runHook($hook, array $data = array())`
> The standard hooks are below. Your object does not need to respond to
> every hook. The return value from a hook will be echoed. 

When you install a component, you are able to use your own hooks, thanks
to PreTTYProcess's usage of `__call()`. This is how indent, outdent,
setTasks, and completeTask all work. The method name gets converted to
all caps and becomes the hook name. The arguments are used as the `$data`
array.

	$component = new MyComponent;
	$process->install($component);

	// this
	$process->customHook(1, 2, 3);

	// is the same as
	$component->runHook('CUSTOMHOOK', array(1, 2, 3));

## Using the PreTTYColorEncoder
ANSI sequences begin a format or move the cursor. If you begin a format
make sure you reset the format to normal before your hook ends. The
sequences just need to be embedded in your output to affect the terminal.

### Main methods
* `->encode($color, $bold = false)`
> This will return a string that, when echoed, turns the text the specified
> color and weight.

* `->reset()`
> This will return a string that, when echoed, resets the text color and
> weight to normal.

* `->moveBack($columns)`
> Moves the cursor right by by the specified number of columns

* `->moveUp($columns)`
> Moves the cursor up by by the specified number of columns

* `->setCursor($line, $column)`
> Moves the cursor to the specified line and column (0,0 is the upper left corner)

* `->saveCursor()`
> saves the position of the cursor so that the `->restoreCursor()` will bring it
> back to this location.

* `->restoreCursor()`
> moves the cursor back to where it was last saved via the method `->saveCursor()`
