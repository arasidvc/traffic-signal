# Traffic Signal Control System (CLI Application)

## Description

As the name indicates it is the traffic lights signal control system.
There are two slots in which different kinds of light signal combinations are there. The first one is the day slot (6 AM to 23 PM) in which ...

1. Green light stays for 30 seconds.
2. Green-Yellow light stays for 5 seconds.
3. Red light stays for 40 seconds.

and the above sequence of light is continued till 11 pm. After 11 pm the next sequence of lights starts in which ...

1. Yellow light stays for 1 second.
2. There is no light for 2 seconds.

and the above sequence is continued till 6 am.

So the above two cycles execute continuously one after the other until we stop the execution.

##### Note
This application is developed using `State Design Pattern`.

### Prerequisites

1. CLI PHP 7.2 or above version required.
2. GIT
3. Composer

### Setup the project

1. Do the git clone of the project.

```
git clone https://git.easternenterprise.com/php/picasse-traffic-signal.git
```
2. Navigate inside the project directory.

```
\> cd traffic-signal
```
3. Install composer dependencies.

```
composer install
```

### Execute the Project.

From the project directory, run the below command.

```
php index.php
```

### Execute Unit Tests.

From the project directory, run the below command.


```
vendor/bin/phpunit
```

To check the unit test coverage report, it can be viewed by running dashboard.html from below path

`log/unit-test/codeCoverage`
