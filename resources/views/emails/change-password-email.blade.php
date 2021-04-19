<html>
<head>

	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

	<title>Cambio de contraseña</title>


	<style type="text/css" media="screen">
		/* Linked Styles */
				body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#ffffff; -webkit-text-size-adjust:none }
				a { color:#ed1f24; text-decoration:none }
				p { padding:0 !important; margin:0 !important } 
				.mcnPreviewText { display: none !important; }
				.cke_editable,
				.cke_editable a,
				.cke_editable span,
				.cke_editable a span { color: #000001 !important; }		
				@media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
					.mobile-shell { width: 100% !important; min-width: 100% !important; }
					.bg { background-size: 100% auto !important; -webkit-background-size: 100% auto !important; }
					
					.text-header,
					.m-center { text-align: center !important; }
					
					.center { margin: 0 auto !important; }
					.container { padding: 20px 10px !important }
					
					.td { width: 100% !important; min-width: 100% !important; }
		
					.m-br-15 { height: 15px !important; }
					.p30-15 { padding: 30px 15px !important; }
					.p0-15-30 { padding: 0px 15px 30px 15px !important; }
					.p0-15 { padding: 0px 15px !important; }
					.mpb30 { padding-bottom: 30px !important; }
					.mpb15 { padding-bottom: 15px !important; }
		
					.m-td,
					.m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }
		
					.m-block { display: block !important; }
		
					.fluid-img img { width: 100% !important; max-width: 100% !important; height: auto !important; }
		
				}
		
	</style>
</head>
<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#000135; -webkit-text-size-adjust:none;">

	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000135">
		<tr>
			<td align="center" valign="top">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center">
							<table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
								<tr>
									<td class="td" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; padding: 40px 20px 40px 20px;">
										<div mc:repeatable="Select" mc:variant="Hero">
											
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td style="font-size:0pt; line-height:0pt; text-align:center; padding-top: 40px;background-color: #ffffff; border-radius:10px 10px 0px 0px;"><img src=https://lh3.googleusercontent.com/-PEoUieZgkzM/YHdRuIEeMDI/AAAAAAAAkoQ/LZcimFnQndQlBZDkKxjnYHQjYQgY3DsYACK8BGAsYHg/s0/2021-04-14.png?authuser=0 width="240px" height="auto" mc:edit="image_2" style="max-width:100%;" alt="" /></td>
												</tr>

												<tr>
													<td class="p30-15" style="padding: 40px 0px 40px 0px; background-color: #ffffff;">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															
															<tr>
																<td style="color:#272727; font-family: 'Roboto', sans-serif; font-size:30px; line-height:32px; text-align:center; padding-bottom:15px;">
																	<div mc:edit="text_2">Cambio de contraseña {{ env('APP_NAME') }}!</div>
																</td>
															</tr>
															<tr>
																<td class="text pb15" style="color:#666666; font-family:Open Sans, sans-serif; font-size:16px; line-height:28px; text-align:center; padding: 30px 30px 0px 30px;">
																	<div mc:edit="text_3">Hemos recibido un solicitud para cambio de contraseña. <br>
																</td>
															</tr>
															<tr>
																<td class="text pb15" style="color:#666666; font-family:Open Sans, sans-serif; font-size:15px; line-height:28px; text-align:left; padding: 0px 30px 0px 30px;">
																	<div mc:edit="text_3">
																		<ul>
																			<li><b>Nombre:</b> {{ $data->name }}</li>
																			<li><b></b> </li>
																			<li><b>Email:</b> {{ $data->email }}</li>
																		</ul>
																	</div>
																</td>
															</tr>
															<tr>
																<td style="color:#272727; font-family: 'Roboto', sans-serif; font-size:15px; line-height:32px; text-align:center; padding-bottom:40px;">
																	<div mc:edit="text_2">
																		<p>Sí ha sido usted el que inició esta acción pulse <a href="#">Aquí</a>. </p>
																	</div>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td height="1" bgcolor="#e5e5e5" class="img" style="font-size:0pt; line-height:0pt; text-align:left;">&nbsp;</td>
												</tr>

											</table>
											</div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="p0-15-30" style="padding-bottom: 40px; padding-top: 40px; background-color: #ffffff; border-radius:0px 0px 10px 10px;">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td class="text-footer2 pb20" style="color:#777777; font-family:Open Sans, sans-serif; font-size:12px; line-height:26px; text-align:center; padding-bottom:0px;">
																	<div mc:edit="text_30">Repcex | Colombia</div>
																</td>
															</tr>
															<tr>
																<td class="text-footer2 pb20" style="color:#777777; font-family:Open Sans, sans-serif; font-size:12px; line-height:26px; text-align:center; padding-bottom:10px;">
																	<div mc:edit="text_30"></div>
																</td>
															</tr>
															<tr>
																<td align="center" style="padding-bottom: 30px;">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="img" width="55" style="font-size:0pt; line-height:0pt; text-align:left;">
																				<a href="#" target="_blank"><img src="https://lh3.googleusercontent.com/-_Y4xo5TOayw/XqIxVreGR6I/AAAAAAAAdVk/ettICRuV_fYFrSjHxBtJno36AibIituiwCK8BGAsYHg/s0/2020-04-23.png" width="20" height="20" mc:edit="image_7" style="max-width:20px;" border="0" alt="" /></a>
																			</td>
																			<td class="img" width="55" style="font-size:0pt; line-height:0pt; text-align:left;">
																				<a href="#" target="_blank"><img src="https://lh3.googleusercontent.com/-8P_Jb3PCoEM/XqIyJx2yovI/AAAAAAAAdVs/xoG_plHtqlQ3u1YNskLoWvPy40Qqot5nQCK8BGAsYHg/s0/2020-04-23.png" width="20" height="20" mc:edit="image_8" style="max-width:20px;" border="0" alt="" /></a>
																			</td>
																			<td class="img" width="55" style="font-size:0pt; line-height:0pt; text-align:left;">
																				<a href="#" target="_blank"><img src="https://lh3.googleusercontent.com/-qDHiD2Js-yc/XqIyfLYQi3I/AAAAAAAAdV0/8AwfVvTQao0rfdnhJ-jB-B_bJ6wgMCjTQCK8BGAsYHg/s0/2020-04-23.png" width="20" height="20" mc:edit="image_9" style="max-width:20px;" border="0" alt="" /></a>
																			</td>
																			<td class="img" width="15" style="font-size:0pt; line-height:0pt; text-align:left;">
																				<a href="#" target="_blank"><img src="https://lh3.googleusercontent.com/-mLu3CvNKYYo/XqIzA1PlXzI/AAAAAAAAdV8/FvrCjexwIDsLy3Lv-FTKoUi4MdxrnjmdACK8BGAsYHg/s0/2020-04-23.png" width="20" height="20" mc:edit="image_10" style="max-width:20px;" border="0" alt="" /></a>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td class="text-footer2" style="color:#777777; font-family:Open Sans, sans-serif; font-size:12px; line-height:26px; text-align:center;">
																	<div mc:edit="text_31"><a class="link2-u" target="_blank" href="*|UNSUB|*" style="color:#777777; text-decoration:underline;">Darse de baja</a> de esta lista de correo.</div>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>