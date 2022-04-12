<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dark And Light Mode</title>
    <link rel="stylesheet" href="../css/contact.css" />
  </head>
  <body>
    <header>
      <h1>Liên Hệ</h1>
      <div class="toggle">
        <input type="checkbox" id="toggleMode" hidden />
        <label for="toggleMode"></label>
      </div>
    </header>
    <main>
      <h2>Light/Dark Mode</h2>
      <div class="box">
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione quis
          quos minima ullam aliquam veritatis ad animi quisquam ipsum voluptatem
          voluptatibus incidunt delectus fuga explicabo, soluta illum est ab.
          Perferendis? Lorem ipsum dolor sit, amet consectetur adipisicing elit.
          Illo obcaecati quae iusto optio nam eum error, voluptatibus molestiae
          nihil quo rem dolorem explicabo temporibus veritatis assumenda porro,
          atque suscipit. Amet!
        </p>
        <div class="box-social">
          <a target="_blank" href="https://www.nodemy.vn/projects-html-css-js"
            >Facebook</a
          >
          <a
            target="_blank"
            href="https://www.youtube.com/watch?v=3odtU8VL3Mc&list=PLodO7Gi1F7R0zA8RkRHcDgnPduNBmjkb5"
            >Youtube</a
          >
          <a
            target="_blank"
            href="https://github.com/namndwebdev/html-css-js-thuc-chien"
            >Github</a
          >
        </div>
      </div>
    </main>

    <script>
        const inputToggle = document.querySelector('#toggleMode')

        inputToggle.addEventListener('change', () => {
            document.body.classList.toggle('dark')
        })
    </script>
  </body>
</html>
