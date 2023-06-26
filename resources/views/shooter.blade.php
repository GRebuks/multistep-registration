<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="//cdn.jsdelivr.net/npm/phaser@3.60.0/dist/phaser.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body class="antialiased">
<div class="game-container" id="shooter">
    <script>
        // Phaser shooter game
        const config = {
            type: Phaser.AUTO,
            width: 1600,
            height: 800,
            backgroundColor: '#000000',
            parent: 'shooter',
            physics: {
                default: 'arcade',
                arcade: {
                    debug: false,
                    gravity: { y: 0 }
                }
            },
            scene: {
                preload: preload,
                create: create,
                update: update
            }
        };

        // game variables
        let game = new Phaser.Game(config);
        let plane;
        let food;
        let cursors;
        let score = 0;
        let scoreText;
        let gameOver = false;
        let movementVector;
        let planePosition, planePositionL, planePositionR;
        let graphics;
        let bullets;
        let bombs;
        let flaks;
        let foodGroup;
        let nextFlak = 0;
        let currentWing = 0;

        // preload assets
        function preload ()
        {
            this.load.image('food', '/assets/food.png');
            this.load.image('body', '/assets/body.png');
            this.load.image('bullet', '/assets/bullet.png');
            this.load.image('bomb', '/assets/bomb.png');
            this.load.image('flak', '/assets/flak.png');
        }

        // create game objects
        function create ()
        {
            // shows user movement vector
            graphics = this.add.graphics();

            //
            bullets = this.physics.add.group({
                defaultKey: 'bullet',
            });
            bombs = this.physics.add.group({
                defaultKey: 'bomb',
                maxSize: 4,
            });
            flaks = this.physics.add.group({
                defaultKey: 'flak',
                maxSize: 20,
            });

            plane = this.physics.add.image(400, 300, 'body');

            foodGroup = this.physics.add.group({
                key: 'food',
                repeat: 0,
                setXY: { x: 400, y: 300, stepX: 32 }
            });

            // create food
            for (let i = 0; i < 200; i++) {
                food = foodGroup.create(Phaser.Math.Between(0, config.width), Phaser.Math.Between(0, config.height), 'food');
                food.setCollideWorldBounds(true);
                food.setBounce(1);
                food.setVelocity(Phaser.Math.Between(-200, 200), Phaser.Math.Between(-200, 200));
                food.setDepth(1);
            }

            // create score text
            scoreText = this.add.text(16, 16, 'score: 0', { fontSize: '32px', fill: '#ffffff' });

            // create keyboard input
            cursors = this.input.keyboard.createCursorKeys();

            // set plane velocity
            plane.setVelocity(Phaser.Math.Between(-200, 200), Phaser.Math.Between(-200, 200));

            // set plane collision
            food.setDepth(1);
            this.physics.world.collide(bullets, foodGroup, handleBulletFoodCollision, null, this);
            this.input.keyboard.on('keydown', event => handleKeyPress(event, planePosition, movementVector), this);
        }

        // update game objects
        function update ()
        {
            movementVector = new Phaser.Math.Vector2(plane.body.velocity.x, plane.body.velocity.y);
            planePosition = new Phaser.Math.Vector2(plane.body.x + plane.width / 2, plane.body.y + plane.height / 2);

            planePositionL = new Phaser.Math.Vector2(plane.body.x + plane.width / 3, plane.body.y + plane.height / 3);
            planePositionR = new Phaser.Math.Vector2(plane.body.x + plane.width / 3 * 2, plane.body.y + plane.height / 3 * 2);

            plane.rotation = Phaser.Math.Angle.Between(0, 0, movementVector.x, movementVector.y);

            // Set the position of the Graphics object to the plane's position
            graphics.x = planePosition.x;
            graphics.y = planePosition.y;

            // Clear the Graphics object
            graphics.clear();

            // Draw the movement vector
            graphics.lineStyle(2, 0x4d4d4d, 1);
            graphics.beginPath();
            graphics.moveTo(0, 0);
            graphics.lineTo(movementVector.x, movementVector.y);
            graphics.closePath();
            graphics.stroke();

            this.physics.world.collide(bullets, foodGroup, handleBulletFoodCollision, null, this);

            // check if game is over
            if (gameOver) {
                console.log('game over');
                return;
            }

            // User border wrap
            if (plane.body.x < 0) plane.body.x = game.config.width;
            else if (plane.body.x > game.config.width) plane.body.x = 0;

            if (plane.body.y < 0) plane.body.y = game.config.height;
            else if (plane.body.y > game.config.height) plane.body.y = 0;

            // Bullet border wrap
            bullets.children.each(function (b) {
                if (b.body.x < 0) {
                    b.body.x = game.config.width;
                }
                if (b.body.x > game.config.width) {
                    b.body.x = 0;
                }
                if (b.body.y < 0) {
                    b.body.y = game.config.height;
                }
                if (b.body.y > game.config.height) {
                    b.body.y = 0;
                }
            });

            // Flak border wrap
            flaks.children.each(function (f) {
                if (f.body.x < 0) {
                    f.body.x = game.config.width;
                }
                if (f.body.x > game.config.width) {
                    f.body.x = 0;
                }
                if (f.body.y < 0) {
                    f.body.y = game.config.height;
                }
                if (f.body.y > game.config.height) {
                    f.body.y = 0;
                }
            });



            // check keyboard input
            if (cursors.left.isDown) {
                if (plane.body.velocity.x > 0) {
                    plane.setVelocityX(plane.body.velocity.x - 20);
                } else {
                    plane.setVelocityX(plane.body.velocity.x - 10);
                }

            }
            if (cursors.right.isDown) {
                if(plane.body.velocity.x < 0) {
                    plane.setVelocityX(plane.body.velocity.x + 20);
                } else {
                    plane.setVelocityX(plane.body.velocity.x + 10);
                }

            }
            if (cursors.up.isDown) {
                if (plane.body.velocity.y > 0) {
                    plane.setVelocityY(plane.body.velocity.y - 20);
                } else {
                    plane.setVelocityY(plane.body.velocity.y - 10);
                }
            }

            if (cursors.down.isDown) {
                if(plane.body.velocity.y < 0) {
                    plane.setVelocityY(plane.body.velocity.y + 20);
                } else {
                    plane.setVelocityY(plane.body.velocity.y + 10);
                }
            }
            if (cursors.space.isDown) {
                shootBullet(planePositionL, movementVector);
                shootBullet(planePositionR, movementVector);
            }
            if (cursors.shift.isDown) {
                if (this.time.now > nextFlak) {
                    //shoot flak
                    if (currentWing === 0) {
                        currentWing = 1;
                        shootFlak(planePositionR, movementVector);
                    } else {
                        currentWing = 0;
                        shootFlak(planePositionL, movementVector);
                    }
                    //set nextFlak to 100ms in the future
                    nextFlak = this.time.now + 100;
                }
            }
        }

        function handleBulletFoodCollision(bullet, food) {
            // Destroy the bullet and the food object
            bullet.destroy();
            food.destroy();
            if(Phaser.Math.Between(1, 3) !== 2) {
                food = foodGroup.create(Phaser.Math.Between(0, 800), Phaser.Math.Between(0, 800), 'food');
                food.setCollideWorldBounds(true);
                food.setBounce(1);
                food.setVelocity(Phaser.Math.Between(-500, 500), Phaser.Math.Between(-500, 500));
                food.setDepth(1);
            } else if (Phaser.Math.Between(1, 30) === 5) {
                for (let i = 0; i < 20; i++) {
                    food = foodGroup.create(Phaser.Math.Between(0, 800), Phaser.Math.Between(0, 800), 'food');
                    food.setCollideWorldBounds(true);
                    food.setBounce(1);
                    food.setVelocity(Phaser.Math.Between(-500, 500), Phaser.Math.Between(-500, 500));
                    food.setDepth(1);
                }
            }

            score += 1;
            scoreText.setText('Score: ' + score);
        }

        function shootBullet(startPosition, directionVector) {
            let bulletSpeed = 500; // Adjust the bullet speed as needed
            let bulletLifetime = 2000; // Adjust the bullet lifetime in milliseconds

            // Normalize the direction vector
            directionVector.normalize();

            // Calculate the bullet's initial position
            let bulletPosition = startPosition.clone();

            // Create a bullet sprite at the initial position
            let bullet = bullets.get(bulletPosition.x, bulletPosition.y);


            if (bullet) {
                // Set the bullet's velocity based on the direction vector and bullet speed
                bullet.setVelocity(directionVector.x * bulletSpeed + plane.body.velocity.x, directionVector.y * bulletSpeed + plane.body.velocity.y);
                bullet.rotation = Phaser.Math.Angle.Between(0, 0, directionVector.x, directionVector.y);

                // Destroy the bullet after the specified lifetime
                setTimeout(function() {
                    bullet.destroy();
                }, bulletLifetime);
            }
        }

        function dropBomb(startPosition, directionVector) {
            let bulletSpeed = 20; // Adjust the bullet speed as needed
            let bulletLifetime = 3000; // Adjust the bullet lifetime in milliseconds

            // Normalize the direction vector
            directionVector.normalize();

            // Calculate the bullet's initial position
            let bulletPosition = startPosition.clone();

            // Create a bullet sprite at the initial position
            let bomb = bombs.get(bulletPosition.x, bulletPosition.y);


            if (bomb) {
                // Set the bullet's velocity based on the direction vector and bullet speed
                bomb.setVelocity(directionVector.x * bulletSpeed, directionVector.y * bulletSpeed);
                bomb.rotation = Phaser.Math.Angle.Between(0, 0, directionVector.x, directionVector.y);

                // Destroy the bullet after the specified lifetime
                setTimeout(function() {
                    bombExplode(bomb);
                }, bulletLifetime);
            }
        }
        function shootFlak(startPosition, directionVector) {
            let bulletSpeed = 500; // Adjust the bullet speed as needed
            let bulletLifetime = 1000; // Adjust the bullet lifetime in milliseconds

            // Normalize the direction vector
            directionVector.normalize();

            // Calculate the bullet's initial position
            let bulletPosition = startPosition.clone();

            // Create a bullet sprite at the initial position
            let flak = flaks.get(bulletPosition.x, bulletPosition.y);


            if (flak) {
                // Set the bullet's velocity based on the direction vector and bullet speed
                flak.setVelocity(directionVector.x * bulletSpeed + plane.body.velocity.x, directionVector.y * bulletSpeed + plane.body.velocity.y);
                flak.rotation = Phaser.Math.Angle.Between(0, 0, directionVector.x, directionVector.y);

                // Destroy the bullet after the specified lifetime
                setTimeout(function() {
                    flakExplode(flak);
                }, bulletLifetime);
            }
        }
        function bombExplode(bomb) {
            bomb.destroy();
            const numBullets = 300; // Number of bullets to launch
            const bulletSpeed = 300; // Speed of the bullets
            const bulletRotationOffset = Math.PI;

            for (let i = 0; i < numBullets; i++) {
                const angle = (i / numBullets) * Math.PI * 2; // Angle of each bullet
                const velocityX = Math.cos(angle) * bulletSpeed;
                const velocityY = Math.sin(angle) * bulletSpeed;
                let bulletLifetime = Phaser.Math.Between(650, 900);

                // Create a bullet with the calculated velocity
                let bullet = bullets.create(bomb.x, bomb.y, 'bullet');
                bullet.setVelocity(velocityX, velocityY);
                bullet.rotation = Phaser.Math.Angle.Between(bullet.x, bullet.y, bomb.x, bomb.y) + bulletRotationOffset;
                setTimeout(function() {
                    bullet.destroy();
                }, bulletLifetime + 400);
            }
        }
        function flakExplode(flak) {
            flak.destroy();

            const numBullets = 60; // Number of bullets to launch
            const bulletSpeed = 2000; // Speed of the bullets
            const bulletRotationOffset = Math.PI;

            for (let i = 0; i < numBullets; i++) {
                const angle = (i / numBullets) * Math.PI * 2; // Angle of each bullet
                const velocityX = Math.cos(angle) * bulletSpeed;
                const velocityY = Math.sin(angle) * bulletSpeed;
                let bulletLifetime = Phaser.Math.Between(70, 150);

                // Create a bullet with the calculated velocity
                let bullet = bullets.create(flak.x, flak.y, 'bullet');
                bullet.setVelocity(velocityX, velocityY);
                bullet.rotation = Phaser.Math.Angle.Between(bullet.x, bullet.y, flak.x, flak.y) + bulletRotationOffset;
                setTimeout(function() {
                    bullet.destroy();
                }, bulletLifetime);
            }
        }
        function handleKeyPress(event, startPosition, directionVector) {
            // Check if the shift key was pressed
            if (event.key === 'Control') {
                // Drop the bomb
                dropBomb(startPosition, directionVector);
            }
        }
    </script>
</div>
</body>
</html>
