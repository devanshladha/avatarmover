<!-- code without avatar image, with avatar image code is commented below -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Museum</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eceff1;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        canvas {
            border: 1px solid #2e3b4e;
            background-color: #fefefe;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        #description {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            color: #333;
        }
    </style>
</head>
<body>
    <canvas id="museumCanvas" width="800" height="600"></canvas>
    <div id="description"></div>

    <script>
        const canvas = document.getElementById('museumCanvas');
        const context = canvas.getContext('2d');
        const avatarSize = 30;
        const artifactSize = 40;
        const artifacts = [
            {x: 200, y: 150, desc: "Ancient Sculpture: A relic from the past."},
            {x: 400, y: 300, desc: "Renaissance Painting: A masterpiece of art."},
            {x: 600, y: 450, desc: "Modern Artwork: A reflection of contemporary thought."}
        ];
        let avatar = {x: 50, y: 50};

        function drawMuseum() {
            context.clearRect(0, 0, canvas.width, canvas.height);

            // Draw avatar
            context.fillStyle = '#3b5998';
            context.fillRect(avatar.x, avatar.y, avatarSize, avatarSize);

            // Draw artifacts
            artifacts.forEach(artifact => {
                context.fillStyle = '#795548';
                context.fillRect(artifact.x, artifact.y, artifactSize, artifactSize);
            });
        }

        function checkProximity() {
            let description = "";
            artifacts.forEach(artifact => {
                let distance = Math.hypot(avatar.x - artifact.x, avatar.y - artifact.y);
                if (distance < artifactSize) {
                    description = artifact.desc;
                }
            });
            document.getElementById('description').textContent = description;
        }

        function isCollision(newX, newY) {
            return artifacts.some(artifact => {
                let artifactX = artifact.x;
                let artifactY = artifact.y;
                return newX < artifactX + artifactSize &&
                       newX + avatarSize > artifactX &&
                       newY < artifactY + artifactSize &&
                       newY + avatarSize > artifactY;
            });
        }

        function moveAvatar(event) {
            const speed = 10;
            let newX = avatar.x;
            let newY = avatar.y;

            switch (event.key) {
                case 'ArrowUp':
                    newY = Math.max(0, avatar.y - speed);
                    break;
                case 'ArrowDown':
                    newY = Math.min(canvas.height - avatarSize, avatar.y + speed);
                    break;
                case 'ArrowLeft':
                    newX = Math.max(0, avatar.x - speed);
                    break;
                case 'ArrowRight':
                    newX = Math.min(canvas.width - avatarSize, avatar.x + speed);
                    break;
            }

            if (!isCollision(newX, newY)) {
                avatar.x = newX;
                avatar.y = newY;
            }

            drawMuseum();
            checkProximity();
        }

        window.addEventListener('keydown', moveAvatar);
        drawMuseum();
    </script>
</body>
</html>





<!-- with avatar image -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Museum</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eceff1;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        canvas {
            border: 1px solid #2e3b4e;
            background-color: #fefefe;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        #description {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            color: #333;
        }
    </style>
</head>
<body>
    <canvas id="museumCanvas" width="800" height="600"></canvas>
    <div id="description"></div>

    <script>
        const canvas = document.getElementById('museumCanvas');
        const context = canvas.getContext('2d');
        const avatarSize = 30;
        const artifactSize = 40;
        const avatarImage = new Image();
        avatarImage.src = '../src/avatar.jpg';  // Update the path to the sprite sheet image
        const frameCount = 11;  // Adjust based on the number of frames in your image
        let currentFrame = 0;

        const artifacts = [
            {x: 200, y: 150, desc: "Ancient Sculpture: A relic from the past."},
            {x: 400, y: 300, desc: "Renaissance Painting: A masterpiece of art."},
            {x: 600, y: 450, desc: "Modern Artwork: A reflection of contemporary thought."}
        ];

        let avatar = {x: 50, y: 50};

        avatarImage.onload = function() {
            drawMuseum();
        }

        function drawMuseum() {
            context.clearRect(0, 0, canvas.width, canvas.height);

            // Draw avatar
            const frameWidth = avatarImage.width / frameCount;
            const frameHeight = avatarImage.height / 4;  // Assuming 4 rows for different directions
            const row = Math.floor(currentFrame / frameCount);
            const col = currentFrame % frameCount;
            context.drawImage(avatarImage, col * frameWidth, row * frameHeight, frameWidth, frameHeight, avatar.x, avatar.y, avatarSize, avatarSize);

            // Draw artifacts
            artifacts.forEach(artifact => {
                context.fillStyle = '#795548';
                context.fillRect(artifact.x, artifact.y, artifactSize, artifactSize);
            });
        }

        function checkProximity() {
            let description = "";
            artifacts.forEach(artifact => {
                let distance = Math.hypot(avatar.x - artifact.x, avatar.y - artifact.y);
                if (distance < artifactSize) {
                    description = artifact.desc;
                }
            });
            document.getElementById('description').textContent = description;
        }

        function isCollision(newX, newY) {
            return artifacts.some(artifact => {
                let artifactX = artifact.x;
                let artifactY = artifact.y;
                return newX < artifactX + artifactSize &&
                       newX + avatarSize > artifactX &&
                       newY < artifactY + artifactSize &&
                       newY + avatarSize > artifactY;
            });
        }

        function moveAvatar(event) {
            const speed = 10;
            let newX = avatar.x;
            let newY = avatar.y;

            switch (event.key) {
                case 'ArrowDown':
                    newY = Math.max(0, avatar.y + speed);
                    currentFrame = (currentFrame + 1) % frameCount + frameCount * 3;  // Update for upward movement
                    break;
                case 'ArrowRight':
                    newX = Math.min(canvas.width - avatarSize, avatar.x + speed);
                    currentFrame = (currentFrame + 1) % frameCount;  // Update for downward movement
                    break;
                case 'ArrowLeft':
                    newX = Math.max(0, avatar.x - speed);
                    currentFrame = (currentFrame + 1) % frameCount + frameCount * 1;  // Update for leftward movement
                    break;
                case 'ArrowUp':
                    newY = Math.min(canvas.height - avatarSize, avatar.y - speed);
                    currentFrame = (currentFrame + 1) % frameCount + frameCount * 2;  // Update for rightward movement
                    break;
            }

            if (!isCollision(newX, newY)) {
                avatar.x = newX;
                avatar.y = newY;
            }

            drawMuseum();
            checkProximity();
        }

        window.addEventListener('keydown', moveAvatar);
    </script>
</body>
</html>

 -->
