<html>
  <head>
    <meta charset="utf-8" />
    <title>Reset Your Password</title>
  </head>

<style>
  *{
    font-family: Tahoma, Geneva, sans-serif;
  }
</style>

  <body>
    
    
    <table cellpadding="0" cellspacing="0" align="center">
      <tbody>
        <tr>
          <td align="center">   <br><br>           
            <b> Hello <?php echo $data['name']; ?></b>
          </td>
        </tr>
        <tr>
          <td align="center">   <br><br>             
            <font size="5"> Reset Your GBI Invoicing System Password</font>
          </td>
        </tr>
        <tr>
          <td align="center">  <br><br>

              <table cellspacing="0" cellpadding="0">
                <tr>
                    <td style="border-radius: 2px;" bgcolor="#ED2939">
                        <a href="<?php echo base_url("resetPasswordConfirmUser/".$data['act_id']."/".$data['act_email']) ?>" target="_blank" style="padding: 8px 12px; border: 1px solid #ED2939; border-radius: 2px; font-size: 14px; color: #ffffff; text-decoration: none; font-weight: bold;display: inline-block; ">
                            Reset My Password             
                        </a>
                    </td>
                </tr>
              </table>

          </td>
        </tr>
        <tr>
          <td  style="padding: 50px"  align="center">           
            Someone - hopefully you - requested a password reset on this account. 
            If it wasn't you, you can safely ignore this message and your password will remain the same.
          </td>
        </tr>
      </tbody>
    </table>
            
  </body>
</html>