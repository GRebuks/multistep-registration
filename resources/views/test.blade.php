<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    <script src="https://cdn.jsdelivr.net/npm/phaser@3.55.2/dist/phaser-arcade-physics.min.js"></script>--}}
    <script src="//cdn.jsdelivr.net/npm/phaser@3.60.0/dist/phaser.js"></script>
    <title>Document</title>
</head>
<body>
    <script>
        // Phaser snake game

        // game config
        const config = {
            type: Phaser.AUTO,
            width: 1600,
            height: 800,
            backgroundColor: '#000000',
            parent: 'phaser-example',
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

        // game letiables
        let game = new Phaser.Game(config);
        let snake;
        let food;
        let cursors;
        let score = 0;
        let scoreText;
        let gameOver = false;
        let movementVector;
        let snakePosition;
        let snakePositionL;
        let snakePositionR;

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
            graphics = this.add.graphics();
            bullets = this.physics.add.group({
                defaultKey: 'bullet',
                //maxSize: 1000 // Adjust the maximum number of bullets as needed
            });
            bombs = this.physics.add.group({
                defaultKey: 'bomb',
                maxSize: 100 // Adjust the maximum number of bullets as needed
            });
            flaks = this.physics.add.group({
                defaultKey: 'flak',
                maxSize: 100 // Adjust the maximum number of bullets as needed
            });
            // create snake
            snake = this.physics.add.group({
                key: 'body',
                repeat: 0,
                setXY: { x: 400, y: 300, stepX: 32 }
            });
            foodGroup = this.physics.add.group({
                key: 'food',
                repeat: 0,
                setXY: { x: 400, y: 300, stepX: 32 }
            });
            // create food
            for (let i = 0; i < 2000; i++) {
                food = foodGroup.create(Phaser.Math.Between(0, 800), Phaser.Math.Between(0, 800), 'food');
                food.setCollideWorldBounds(true);
                food.setBounce(1);
                food.setVelocity(Phaser.Math.Between(-200, 200), Phaser.Math.Between(-200, 200));
                food.setDepth(1);
            }
            // create score text
            scoreText = this.add.text(16, 16, 'score: 0', { fontSize: '32px', fill: '#ffffff' });

            // create keyboard input
            cursors = this.input.keyboard.createCursorKeys();

            // set snake velocity
            snake.children.iterate(function (child) {
                child.setVelocity(Phaser.Math.Between(-200, 200), Phaser.Math.Between(-200, 200));
            });

            // set snake collision
            food.setDepth(1);
            this.physics.add.collider(snake, snake);
            this.physics.world.collide(bullets, foodGroup, handleBulletFoodCollision, null, this);
            this.input.keyboard.on('keydown', event => handleKeyPress(event, snakePosition, movementVector), this);
        }

        // update game objects
        function update ()
        {
            movementVector = new Phaser.Math.Vector2(snake.getChildren()[0].body.velocity.x, snake.getChildren()[0].body.velocity.y);
            snakePosition = new Phaser.Math.Vector2(snake.getChildren()[0].body.x + snake.getChildren()[0].width / 2, snake.getChildren()[0].body.y + snake.getChildren()[0].height / 2);

            snakePositionL = new Phaser.Math.Vector2(snake.getChildren()[0].body.x + snake.getChildren()[0].width / 3, snake.getChildren()[0].body.y + snake.getChildren()[0].height / 3);
            snakePositionR = new Phaser.Math.Vector2(snake.getChildren()[0].body.x + snake.getChildren()[0].width / 3 * 2, snake.getChildren()[0].body.y + snake.getChildren()[0].height / 3 * 2);


            snake.getChildren()[0].rotation = Phaser.Math.Angle.Between(0, 0, movementVector.x, movementVector.y);

            // Set the position of the Graphics object to the snake's position
            graphics.x = snakePosition.x;
            graphics.y = snakePosition.y;

            // Clear the Graphics object
            graphics.clear();

            // Draw the movement vector
            graphics.lineStyle(2, 0xFFFFFF, 1);
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

            // Check if the snake has crossed the screen borders
            if (snake.getChildren()[0].body.x < 0) {
                // If the snake crosses the left border, wrap it to the right side
                snake.getChildren()[0].body.x = game.config.width;
            } else if (snake.getChildren()[0].body.x > game.config.width) {
                // If the snake crosses the right border, wrap it to the left side
                snake.getChildren()[0].body.x = 0;
            }

            if (snake.getChildren()[0].body.y < 0) {
                // If the snake crosses the top border, wrap it to the bottom side
                snake.getChildren()[0].body.y = game.config.height;
            } else if (snake.getChildren()[0].body.y > game.config.height) {
                // If the snake crosses the bottom border, wrap it to the top side
                snake.getChildren()[0].body.y = 0;
            }

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


            // check if snake is eating itself
            let head = snake.getChildren()[0];
            snake.children.iterate(function (child) {
                if (child != head && child.x == head.x && child.y == head.y) {
                    gameOver = true;
                    return;
                }
            });

            // check keyboard input
            if (cursors.left.isDown) {
                if (snake.getChildren()[0].body.velocity.x > 0) {
                    snake.setVelocityX(snake.getChildren()[0].body.velocity.x - 20);
                } else {
                    snake.setVelocityX(snake.getChildren()[0].body.velocity.x - 10);
                }

            }
            if (cursors.right.isDown) {
                if(snake.getChildren()[0].body.velocity.x < 0) {
                    snake.setVelocityX(snake.getChildren()[0].body.velocity.x + 20);
                } else {
                    snake.setVelocityX(snake.getChildren()[0].body.velocity.x + 10);
                }

            }
            if (cursors.up.isDown) {
                if (snake.getChildren()[0].body.velocity.y > 0) {
                    snake.setVelocityY(snake.getChildren()[0].body.velocity.y - 20);
                } else {
                    snake.setVelocityY(snake.getChildren()[0].body.velocity.y - 10);
                }
            }

            if (cursors.down.isDown) {
                if(snake.getChildren()[0].body.velocity.y < 0) {
                    snake.setVelocityY(snake.getChildren()[0].body.velocity.y + 20);
                } else {
                    snake.setVelocityY(snake.getChildren()[0].body.velocity.y + 10);
                }
            }
            if (cursors.space.isDown) {
                shootBullet(snakePositionL, movementVector);
                shootBullet(snakePositionR, movementVector);
            }
            if (cursors.shift.isDown) {
                shootFlak(snakePosition, movementVector);
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
            //
            // food = foodGroup.create(Phaser.Math.Between(0, 800), Phaser.Math.Between(0, 800), 'food');
            // food.setCollideWorldBounds(true);
            // food.setBounce(1);
            // food.setVelocity(Phaser.Math.Between(-500, 500), Phaser.Math.Between(-500, 500));
            // food.setDepth(1);

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
                bullet.setVelocity(directionVector.x * bulletSpeed, directionVector.y * bulletSpeed);
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
            let bulletLifetime = 1500; // Adjust the bullet lifetime in milliseconds

            // Normalize the direction vector
            directionVector.normalize();

            // Calculate the bullet's initial position
            let bulletPosition = startPosition.clone();

            // Create a bullet sprite at the initial position
            let flak = flaks.get(bulletPosition.x, bulletPosition.y);


            if (flak) {
                // Set the bullet's velocity based on the direction vector and bullet speed
                flak.setVelocity(directionVector.x * bulletSpeed, directionVector.y * bulletSpeed);
                flak.rotation = Phaser.Math.Angle.Between(0, 0, directionVector.x, directionVector.y);

                // Destroy the bullet after the specified lifetime
                setTimeout(function() {
                    flakExplode(flak);
                }, bulletLifetime);
            }
        }
        function bombExplode(bomb) {
            bomb.destroy();
            const numBullets = 200; // Number of bullets to launch
            const bulletSpeed = 300; // Speed of the bullets
            const bulletRotationOffset = Math.PI;

            for (let i = 0; i < numBullets; i++) {
                const angle = (i / numBullets) * Math.PI * 2; // Angle of each bullet
                const velocityX = Math.cos(angle) * bulletSpeed;
                const velocityY = Math.sin(angle) * bulletSpeed;
                let bulletLifetime = Phaser.Math.Between(500, 700);

                // Create a bullet with the calculated velocity
                let bullet = bullets.create(bomb.x, bomb.y, 'bullet');
                bullet.setVelocity(velocityX, velocityY);
                const rotationAngle = Phaser.Math.Angle.Between(bullet.x, bullet.y, bomb.x, bomb.y) + bulletRotationOffset;
                bullet.rotation = rotationAngle;
                setTimeout(function() {
                    bullet.destroy();
                }, bulletLifetime);
            }
        }
        function flakExplode(flak) {
            flak.destroy();
            const numBullets = 16; // Number of bullets to launch
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
                const rotationAngle = Phaser.Math.Angle.Between(bullet.x, bullet.y, flak.x, flak.y) + bulletRotationOffset;
                bullet.rotation = rotationAngle;
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
</body>
</html>
