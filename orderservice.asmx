<?xml version="1.0" encoding="utf-8"?>
<wsdl:definitions xmlns:s="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://schemas.xmlsoap.org/wsdl/soap12/" xmlns:mime="http://schemas.xmlsoap.org/wsdl/mime/" xmlns:tns="http://shippingapi.ebay.cn/" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" xmlns:tm="http://microsoft.com/wsdl/mime/textMatching/" xmlns:http="http://schemas.xmlsoap.org/wsdl/http/" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" targetNamespace="http://shippingapi.ebay.cn/" xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">
  <wsdl:types>
    <s:schema elementFormDefault="qualified" targetNamespace="http://shippingapi.ebay.cn/">
      <s:element name="AddAPACShippingPackage">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="AddAPACShippingPackageRequest" type="tns:AddAPACShippingPackageRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="AddAPACShippingPackageRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="OrderDetail" type="tns:OrderDetail" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:complexType name="BaseRequest">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="Version" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="APIDevUserID" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="APIPassword" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="APISellerUserID" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="MessageID" type="s:string" />
        </s:sequence>
      </s:complexType>
      <s:complexType name="OrderDetail">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="PickUpAddress" type="tns:PickUpAddress" />
          <s:element minOccurs="0" maxOccurs="1" name="ShipFromAddress" type="tns:ShipFromAddress" />
          <s:element minOccurs="0" maxOccurs="1" name="ShipToAddress" type="tns:ShipToAddress" />
          <s:element minOccurs="0" maxOccurs="1" name="ItemList" type="tns:ItemList" />
          <s:element minOccurs="1" maxOccurs="1" name="EMSPickUpType" type="s:int" />
          <s:element minOccurs="0" maxOccurs="1" name="ReturnAddress" type="tns:ReturnAddress" />
        </s:sequence>
      </s:complexType>
      <s:complexType name="PickUpAddress">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="Email" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Company" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Country" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Province" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="City" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="District" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Street" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Postcode" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Contact" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Mobile" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Phone" type="s:string" />
        </s:sequence>
      </s:complexType>
      <s:complexType name="ShipFromAddress">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="Contact" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Company" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Street" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="District" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="City" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Province" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Postcode" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Country" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Email" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Mobile" type="s:string" />
        </s:sequence>
      </s:complexType>
      <s:complexType name="ShipToAddress">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="Email" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Company" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Contact" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Phone" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Street" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="City" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Province" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Postcode" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Country" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="CountryCode" type="s:string" />
        </s:sequence>
      </s:complexType>
      <s:complexType name="ItemList">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="unbounded" name="Item" type="tns:Item" />
        </s:sequence>
      </s:complexType>
      <s:complexType name="Item">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="CurrencyCode" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="EBayEmail" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="EBayBuyerID" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="EBayItemID" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="EBayItemTitle" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="EBayMessage" type="s:string" />
          <s:element minOccurs="1" maxOccurs="1" name="EBaySiteID" type="s:int" />
          <s:element minOccurs="0" maxOccurs="1" name="EBayTransactionID" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Note" type="s:string" />
          <s:element minOccurs="1" maxOccurs="1" name="OrderSalesRecordNumber" type="s:int" />
          <s:element minOccurs="1" maxOccurs="1" name="PaymentDate" type="s:dateTime" />
          <s:element minOccurs="0" maxOccurs="1" name="PayPalEmail" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="PayPalMessage" type="s:string" />
          <s:element minOccurs="1" maxOccurs="1" name="PostedQTY" type="s:int" />
          <s:element minOccurs="1" maxOccurs="1" name="ReceivedAmount" type="s:decimal" />
          <s:element minOccurs="1" maxOccurs="1" name="SalesRecordNumber" type="s:int" />
          <s:element minOccurs="1" maxOccurs="1" name="SoldDate" type="s:dateTime" />
          <s:element minOccurs="1" maxOccurs="1" name="SoldPrice" type="s:decimal" />
          <s:element minOccurs="1" maxOccurs="1" name="SoldQTY" type="s:int" />
          <s:element minOccurs="0" maxOccurs="1" name="SKU" type="tns:SKU" />
        </s:sequence>
      </s:complexType>
      <s:complexType name="SKU">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="SKUID" type="s:string" />
          <s:element minOccurs="1" maxOccurs="1" name="Weight" type="s:decimal" />
          <s:element minOccurs="0" maxOccurs="1" name="CustomsTitleCN" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="CustomsTitleEN" type="s:string" />
          <s:element minOccurs="1" maxOccurs="1" name="DeclaredValue" type="s:decimal" />
          <s:element minOccurs="0" maxOccurs="1" name="OriginCountryName" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="OriginCountryCode" type="s:string" />
        </s:sequence>
      </s:complexType>
      <s:complexType name="ReturnAddress">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="Company" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Contact" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Postcode" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Street" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="District" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="City" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Province" type="s:string" />
          <s:element minOccurs="0" maxOccurs="1" name="Country" type="s:string" />
        </s:sequence>
      </s:complexType>
      <s:element name="AddAPACShippingPackageResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="AddAPACShippingPackageResult" type="tns:AddAPACShippingPackageResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="AddAPACShippingPackageResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:complexType name="BaseResponse">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="1" name="Version" type="s:string" />
          <s:element minOccurs="1" maxOccurs="1" name="Ack" type="tns:EnumAck" />
          <s:element minOccurs="0" maxOccurs="1" name="Message" type="s:string" />
          <s:element minOccurs="1" maxOccurs="1" name="Timestamp" type="s:dateTime" />
          <s:element minOccurs="0" maxOccurs="1" name="InvocationID" type="s:string" />
        </s:sequence>
      </s:complexType>
      <s:simpleType name="EnumAck">
        <s:restriction base="s:string">
          <s:enumeration value="Failure" />
          <s:enumeration value="Success" />
          <s:enumeration value="PartialFailure" />
          <s:enumeration value="Warning" />
        </s:restriction>
      </s:simpleType>
      <s:element name="CancelAPACShippingPackage">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="CancelAPACShippingPackageRequest" type="tns:CancelAPACShippingPackageRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="CancelAPACShippingPackageRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="CancelAPACShippingPackageResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="CancelAPACShippingPackageResult" type="tns:CancelAPACShippingPackageResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="CancelAPACShippingPackageResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse" />
        </s:complexContent>
      </s:complexType>
      <s:element name="ConfirmAPACShippingPackage">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="ConfirmAPACShippingPackageRequest" type="tns:ConfirmAPACShippingPackageRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="ConfirmAPACShippingPackageRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="ConfirmAPACShippingPackageResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="ConfirmAPACShippingPackageResult" type="tns:ConfirmAPACShippingPackageResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="ConfirmAPACShippingPackageResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse" />
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingLabel">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingLabelRequest" type="tns:GetAPACShippingLabelRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingLabelRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
              <s:element minOccurs="1" maxOccurs="1" name="PageSize" type="s:int" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingLabelResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingLabelResult" type="tns:GetAPACShippingLabelResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingLabelResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="Label" type="s:base64Binary" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingLabels">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingLabelRequest" type="tns:GetAPACShippingLabelsRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingLabelsRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCodeList" type="tns:TrackCodeList" />
              <s:element minOccurs="1" maxOccurs="1" name="PageSize" type="s:int" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:complexType name="TrackCodeList">
        <s:sequence>
          <s:element minOccurs="0" maxOccurs="unbounded" name="TrackCode" type="s:string" />
        </s:sequence>
      </s:complexType>
      <s:element name="GetAPACShippingLabelsResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingLabelsResult" type="tns:GetAPACShippingLabelsResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingLabelsResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="Label" type="s:base64Binary" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingPackage">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingPackageRequest" type="tns:GetAPACShippingPackageRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingPackageRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingPackageResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingPackageResult" type="tns:GetAPACShippingPackageResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingPackageResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="OrderDetail" type="tns:OrderDetail" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingPackageStatus">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingPackageStatusRequest" type="tns:GetAPACShippingPackageStatusRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingPackageStatusRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingPackageStatusResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingPackageStatusResult" type="tns:GetAPACShippingPackageStatusResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingPackageStatusResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse">
            <s:sequence>
              <s:element minOccurs="1" maxOccurs="1" name="Status" type="s:int" />
              <s:element minOccurs="0" maxOccurs="1" name="Note" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingRate">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingRateRequest" type="tns:GetAPACShippingRateRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingRateRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="1" maxOccurs="1" name="ShipCode" type="s:int" />
              <s:element minOccurs="0" maxOccurs="1" name="CountryCode" type="s:string" />
              <s:element minOccurs="1" maxOccurs="1" name="Weight" type="s:decimal" />
              <s:element minOccurs="1" maxOccurs="1" name="InsuranceType" type="s:int" />
              <s:element minOccurs="1" maxOccurs="1" name="InsuranceAmount" type="s:decimal" />
              <s:element minOccurs="1" maxOccurs="1" name="MailType" type="s:int" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingRateResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingRateResult" type="tns:GetAPACShippingRateResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingRateResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse">
            <s:sequence>
              <s:element minOccurs="1" maxOccurs="1" name="DeliveryCharge" type="s:decimal" />
              <s:element minOccurs="1" maxOccurs="1" name="AdditionalCharge" type="s:decimal" />
              <s:element minOccurs="1" maxOccurs="1" name="InsuranceFee" type="s:decimal" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="VerifyAPACShippingUser">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="VerifyAPACShippingUserRequest" type="tns:VerifyAPACShippingUserRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="VerifyAPACShippingUserRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest" />
        </s:complexContent>
      </s:complexType>
      <s:element name="VerifyAPACShippingUserResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="VerifyAPACShippingUserResult" type="tns:VerifyAPACShippingUserResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="VerifyAPACShippingUserResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse" />
        </s:complexContent>
      </s:complexType>
      <s:element name="RecreateAPACShippingPackage">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="RecreateAPACShippingPackageRequest" type="tns:RecreateAPACShippingPackageRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="RecreateAPACShippingPackageRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="RecreateAPACShippingPackageResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="RecreateAPACShippingPackageResult" type="tns:RecreateAPACShippingPackageResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="RecreateAPACShippingPackageResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingTrackCode">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingTrackCodeRequest" type="tns:GetAPACShippingTrackCodeRequest" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingTrackCodeRequest">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseRequest">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="EBayItemID" type="s:string" />
              <s:element minOccurs="0" maxOccurs="1" name="EBayTransactionID" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
      <s:element name="GetAPACShippingTrackCodeResponse">
        <s:complexType>
          <s:sequence>
            <s:element minOccurs="0" maxOccurs="1" name="GetAPACShippingTrackCodeResult" type="tns:GetAPACShippingTrackCodeResponse" />
          </s:sequence>
        </s:complexType>
      </s:element>
      <s:complexType name="GetAPACShippingTrackCodeResponse">
        <s:complexContent mixed="false">
          <s:extension base="tns:BaseResponse">
            <s:sequence>
              <s:element minOccurs="0" maxOccurs="1" name="TrackCode" type="s:string" />
            </s:sequence>
          </s:extension>
        </s:complexContent>
      </s:complexType>
    </s:schema>
  </wsdl:types>
  <wsdl:message name="AddAPACShippingPackageSoapIn">
    <wsdl:part name="parameters" element="tns:AddAPACShippingPackage" />
  </wsdl:message>
  <wsdl:message name="AddAPACShippingPackageSoapOut">
    <wsdl:part name="parameters" element="tns:AddAPACShippingPackageResponse" />
  </wsdl:message>
  <wsdl:message name="CancelAPACShippingPackageSoapIn">
    <wsdl:part name="parameters" element="tns:CancelAPACShippingPackage" />
  </wsdl:message>
  <wsdl:message name="CancelAPACShippingPackageSoapOut">
    <wsdl:part name="parameters" element="tns:CancelAPACShippingPackageResponse" />
  </wsdl:message>
  <wsdl:message name="ConfirmAPACShippingPackageSoapIn">
    <wsdl:part name="parameters" element="tns:ConfirmAPACShippingPackage" />
  </wsdl:message>
  <wsdl:message name="ConfirmAPACShippingPackageSoapOut">
    <wsdl:part name="parameters" element="tns:ConfirmAPACShippingPackageResponse" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingLabelSoapIn">
    <wsdl:part name="parameters" element="tns:GetAPACShippingLabel" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingLabelSoapOut">
    <wsdl:part name="parameters" element="tns:GetAPACShippingLabelResponse" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingLabelsSoapIn">
    <wsdl:part name="parameters" element="tns:GetAPACShippingLabels" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingLabelsSoapOut">
    <wsdl:part name="parameters" element="tns:GetAPACShippingLabelsResponse" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingPackageSoapIn">
    <wsdl:part name="parameters" element="tns:GetAPACShippingPackage" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingPackageSoapOut">
    <wsdl:part name="parameters" element="tns:GetAPACShippingPackageResponse" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingPackageStatusSoapIn">
    <wsdl:part name="parameters" element="tns:GetAPACShippingPackageStatus" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingPackageStatusSoapOut">
    <wsdl:part name="parameters" element="tns:GetAPACShippingPackageStatusResponse" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingRateSoapIn">
    <wsdl:part name="parameters" element="tns:GetAPACShippingRate" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingRateSoapOut">
    <wsdl:part name="parameters" element="tns:GetAPACShippingRateResponse" />
  </wsdl:message>
  <wsdl:message name="VerifyAPACShippingUserSoapIn">
    <wsdl:part name="parameters" element="tns:VerifyAPACShippingUser" />
  </wsdl:message>
  <wsdl:message name="VerifyAPACShippingUserSoapOut">
    <wsdl:part name="parameters" element="tns:VerifyAPACShippingUserResponse" />
  </wsdl:message>
  <wsdl:message name="RecreateAPACShippingPackageSoapIn">
    <wsdl:part name="parameters" element="tns:RecreateAPACShippingPackage" />
  </wsdl:message>
  <wsdl:message name="RecreateAPACShippingPackageSoapOut">
    <wsdl:part name="parameters" element="tns:RecreateAPACShippingPackageResponse" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingTrackCodeSoapIn">
    <wsdl:part name="parameters" element="tns:GetAPACShippingTrackCode" />
  </wsdl:message>
  <wsdl:message name="GetAPACShippingTrackCodeSoapOut">
    <wsdl:part name="parameters" element="tns:GetAPACShippingTrackCodeResponse" />
  </wsdl:message>
  <wsdl:portType name="OrderServiceSoap">
    <wsdl:operation name="AddAPACShippingPackage">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Add APAC shipping package service:&lt;br/&gt;Creates an APAC shipping package and generate a tracking number for the package. </wsdl:documentation>
      <wsdl:input message="tns:AddAPACShippingPackageSoapIn" />
      <wsdl:output message="tns:AddAPACShippingPackageSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="CancelAPACShippingPackage">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Cancel APAC shipping package service:&lt;br/&gt;Cancels an APAC shipping package. A package can only be canceled when its status is New Order. After cancellation, the record will be permanently removed from database.</wsdl:documentation>
      <wsdl:input message="tns:CancelAPACShippingPackageSoapIn" />
      <wsdl:output message="tns:CancelAPACShippingPackageSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="ConfirmAPACShippingPackage">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Confirm APAC shipping package service:&lt;br/&gt;Confirms a shipping package. The package information will be uploaded to China Post system. Afterward, the package cannot be canceled or revised.</wsdl:documentation>
      <wsdl:input message="tns:ConfirmAPACShippingPackageSoapIn" />
      <wsdl:output message="tns:ConfirmAPACShippingPackageSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingLabel">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Get APAC shipping label service:&lt;br/&gt;Retrieves an APAC shipping package label in PDF format.</wsdl:documentation>
      <wsdl:input message="tns:GetAPACShippingLabelSoapIn" />
      <wsdl:output message="tns:GetAPACShippingLabelSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingLabels">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Get APAC shipping labels service:&lt;br/&gt;Retrieve up to 80 APAC shipping package labels at one time in one PDF.</wsdl:documentation>
      <wsdl:input message="tns:GetAPACShippingLabelsSoapIn" />
      <wsdl:output message="tns:GetAPACShippingLabelsSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingPackage">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Get APAC shipping package detail service:&lt;br/&gt;Retrieves an APAC shipping package.</wsdl:documentation>
      <wsdl:input message="tns:GetAPACShippingPackageSoapIn" />
      <wsdl:output message="tns:GetAPACShippingPackageSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingPackageStatus">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Get APAC shipping packageStatus service:&lt;br/&gt;Retrieves delivery status of an APAC shipping package.</wsdl:documentation>
      <wsdl:input message="tns:GetAPACShippingPackageStatusSoapIn" />
      <wsdl:output message="tns:GetAPACShippingPackageStatusSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingRate">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Get APAC shipping rate service:&lt;br/&gt;Calculates the shipping cost of an APAC shipping package.</wsdl:documentation>
      <wsdl:input message="tns:GetAPACShippingRateSoapIn" />
      <wsdl:output message="tns:GetAPACShippingRateSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="VerifyAPACShippingUser">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Verify APAC Shipping User service:&lt;br/&gt;Verify whether user authorization is success or not.</wsdl:documentation>
      <wsdl:input message="tns:VerifyAPACShippingUserSoapIn" />
      <wsdl:output message="tns:VerifyAPACShippingUserSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="RecreateAPACShippingPackage">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Recreate APAC shipping package service:&lt;br/&gt;Recreates a already posted shipping package. A shipping package can only be Recreated when its status is In-Transit,Deliver Success or Delivery Fail. For some cases a seller may need to recreate a shipping package. After recreation, the shipping package's status will be reset to New Order.</wsdl:documentation>
      <wsdl:input message="tns:RecreateAPACShippingPackageSoapIn" />
      <wsdl:output message="tns:RecreateAPACShippingPackageSoapOut" />
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingTrackCode">
      <wsdl:documentation xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">Get APAC Shipping TrackCode service:&lt;br/&gt;Retrieves the trackcode of a shipping package that includes the item. If the item is not included in any packge, it returns null.</wsdl:documentation>
      <wsdl:input message="tns:GetAPACShippingTrackCodeSoapIn" />
      <wsdl:output message="tns:GetAPACShippingTrackCodeSoapOut" />
    </wsdl:operation>
  </wsdl:portType>
  <wsdl:binding name="OrderServiceSoap" type="tns:OrderServiceSoap">
    <soap:binding transport="http://schemas.xmlsoap.org/soap/http" />
    <wsdl:operation name="AddAPACShippingPackage">
      <soap:operation soapAction="http://shippingapi.ebay.cn/AddAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="CancelAPACShippingPackage">
      <soap:operation soapAction="http://shippingapi.ebay.cn/CancelAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="ConfirmAPACShippingPackage">
      <soap:operation soapAction="http://shippingapi.ebay.cn/ConfirmAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingLabel">
      <soap:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingLabel" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingLabels">
      <soap:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingLabels" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingPackage">
      <soap:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingPackageStatus">
      <soap:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingPackageStatus" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingRate">
      <soap:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingRate" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="VerifyAPACShippingUser">
      <soap:operation soapAction="http://shippingapi.ebay.cn/VerifyAPACShippingUser" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="RecreateAPACShippingPackage">
      <soap:operation soapAction="http://shippingapi.ebay.cn/RecreateAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingTrackCode">
      <soap:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingTrackCode" style="document" />
      <wsdl:input>
        <soap:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
  </wsdl:binding>
  <wsdl:binding name="OrderServiceSoap12" type="tns:OrderServiceSoap">
    <soap12:binding transport="http://schemas.xmlsoap.org/soap/http" />
    <wsdl:operation name="AddAPACShippingPackage">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/AddAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="CancelAPACShippingPackage">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/CancelAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="ConfirmAPACShippingPackage">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/ConfirmAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingLabel">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingLabel" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingLabels">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingLabels" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingPackage">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingPackageStatus">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingPackageStatus" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingRate">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingRate" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="VerifyAPACShippingUser">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/VerifyAPACShippingUser" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="RecreateAPACShippingPackage">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/RecreateAPACShippingPackage" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
    <wsdl:operation name="GetAPACShippingTrackCode">
      <soap12:operation soapAction="http://shippingapi.ebay.cn/GetAPACShippingTrackCode" style="document" />
      <wsdl:input>
        <soap12:body use="literal" />
      </wsdl:input>
      <wsdl:output>
        <soap12:body use="literal" />
      </wsdl:output>
    </wsdl:operation>
  </wsdl:binding>
  <wsdl:service name="OrderService">
    <wsdl:port name="OrderServiceSoap" binding="tns:OrderServiceSoap">
      <soap:address location="http://shippingapi.ebay.cn/production/v3/orderservice.asmx" />
    </wsdl:port>
    <wsdl:port name="OrderServiceSoap12" binding="tns:OrderServiceSoap12">
      <soap12:address location="http://shippingapi.ebay.cn/production/v3/orderservice.asmx" />
    </wsdl:port>
  </wsdl:service>
</wsdl:definitions>